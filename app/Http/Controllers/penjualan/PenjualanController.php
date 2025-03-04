<?php

namespace App\Http\Controllers\penjualan;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function generatePOCode()
    {
        try {
            $currentYear = Carbon::now()->format('Y');
            $lastCode = Session::get('last_po_code');
            if ($lastCode && strpos($lastCode, 'PO' . $currentYear) === 0) {
                $lastNumber = intval(substr($lastCode, -4));
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }
            $poCode = 'PO' . $currentYear . $newNumber;
            return $poCode;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating PO code: ' . $e->getMessage()
            ], 500);
        }
    }

    public function ajaxselling(Request $request)
    {
        $search = $request->input('search.value') ?? '';
        $month = $request->input('month', 11);
        $year = $request->input('year', 0);
        $length = $request->input('length', 10);
        $start = $request->input('start', 0);


        $requestbody = [
            'search' => $search,
            'month' => $month,
            'year' => 2024,
            'limit' => $length,
            'offset' => $start,
            'company_id' => 0,
        ];

        $payloadmtd = [
            'month' => $month,
            'year' => $year,
            'company_id' => 2,
        ];

        if (!empty($search)) {
            $requestbody['search'] = $search;
        }

        $apiResponse = storeApi(env('PENJUALAN_URL') . '/list', $requestbody);
        $mtdResponse = storeApi(env('PENJUALAN_URL') . '/mtd', $payloadmtd);

        if ($request->ajax()) {
            try {
                if ($apiResponse->successful() && $mtdResponse->successful()) {
                    $data = $apiResponse->json();
                    $mtd = $mtdResponse->json();
                    return response()->json([
                        'draw' => $request->input('draw'),
                        'recordsTotal' => $data['data']['jumlah_filter'] ?? 0,
                        'recordsFiltered' => $data['data']['jumlah'] ?? 0,
                        'data' => $data['data']['table'] ?? [],
                        'mtd' => $mtd['data'] ?? [],
                    ]);
                }
                return response()->json(['error' => 'Failed to fetch data'], 500);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function index()
    {
        //
        return view('penjualan.penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $company_id = 2;
        $customer = 'true';
        $suplier = 'false';
        $data = [
            'company_id' => 2
        ];

        $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $company_id . '/' . $suplier . '/' . $customer);
        $gudangResponse = fectApi(env('LIST_GUDANG') . '/' . $company_id);

        if ($partnerResponse->successful() && $gudangResponse->successful()) {
            $partner = json_decode($partnerResponse->getbody()->getContents(), false);
            $gudang = json_decode($gudangResponse->getbody()->getContents(), false);

            // $poCode = $this->generatePOCode();
            return view('penjualan.penjualan.add', compact('partner', 'gudang', ));
        } else {
            $errors = [];
            if (!$gudangResponse->successful()) {
                $errors[] = $gudangResponse->json()['message'];
            }
            if (!$partnerResponse->successful()) {
                $errors[] = $partnerResponse->json()['message'];
            }
            return back()->withErrors($errors);
        }

    }

    protected function getItemsList($company_id)
    {
        $apiUrl = env('LIST_ITEMS');
        $response = storeApi($apiUrl, ['company_id' => $company_id]);

        if ($response->successful()) {
            $items = $response->json()['data']['items'] ?? [];
            $unit_of_measure_id = $response->json()['data']['unit_of_measure_id'] ?? [];
            $sku = $response->json()['data']['sku'] ?? [];
            return response()->json(['items' => $items, 'unit_of_measure_id' => $unit_of_measure_id, 'sku' => $sku]);
        }

        return response()->json(['items' => [], 'unit_of_measure_id' => []]);
    }
    protected function getstock($id)
    {
        $apiResponse = fectApi(env('STOCK_ITEM') . '/' . $id);

        if ($apiResponse->successful()) {
            $stock = $apiResponse->json()['data']['stock'] ?? [];
            return response()->json(['stock' => $stock]);
        }

        return response()->json(['stock' => []]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $itemsRequest = $request->input('items');
            $warehouseId = isset($itemsRequest[0]['warehouse_id']) ?
                (int) $itemsRequest[0]['warehouse_id'] : 0;

            $items = [];
            foreach ($itemsRequest as $itemData) {
                $entry = [
                    // 'sales_order_id' => 1,
                    'item_id' => (int) ($itemData['item_id'] ?? 0),
                    'unit_price' => (float) ($itemData['unit_price'] ?? 0),
                    'quantity' => (int) ($itemData['quantity'] ?? 0),
                    'box_quantity' => $itemData['box_quantity'],
                    'per_box_quantity' => $itemData['per_box_quantity'] ?? 0,
                    'discount' => $itemData['discount'] ?? 0,
                    'notes' => ($itemData['notes'] ?? ''),
                    // 'mutation_id' => $itemData['notes'] ?? 0,
                    'uom_id' => (int) ($itemData['uom_id'] ?? 0),
                    'warehouse_id' => $warehouseId,
                ];

                $items[] = $entry;
            }

            $data = [
                "sales_id" => 1,
                "order_number" => $request->input('order_number' ?? 1),
                "order_date" => $request->input('order_date'),
                "delivery_date" => $request->input('delivery_date'),
                'partner_id' => $request->input('partner_id'),
                'term_of_payment' => $request->input('term_of_payment'),
                'total_amount' => (float) $request->input('total_amount'),
                'coa_id' => 999,
                'payment_coa' => 0,
                'currency_id' => $request->input('currency_id'),
                'tax_rate' => $request->input('tax_rate'),
                'tax_amount' => (float) $request->input('tax_amount'),
                'sequence_number' => 10,
                'status' => 'diterima',
                'description' => $request->input('description'),
                'company_id' => 2,
                'warehouse_id' => $warehouseId,
                'items' => $items,
            ];
            $apiResponse = storeApi(env('PENJUALAN_URL'), $data);
            // dd($apiResponse->json(), $data);
            if ($apiResponse->successful()) {
                // Session::put('last_po_code', $request->input('code'));
                return redirect()->route('penjualan.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $apiResponse = fectApi(env('PENJUALAN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                // dd($data);
                return view('penjualan.penjualan.detail', compact('data'));
            } else {
                return back()->withErrors('Gagal mengambil data item: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $company_id = 2;
        $customer = 'true';
        $suplier = 'false';


        $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $company_id . '/' . $suplier . '/' . $customer);
        $gudangResponse = fectApi(env('LIST_GUDANG') . '/' . $company_id);
        $apiResponse = fectApi(env('PENJUALAN_URL') . '/' . $id);
        $itemsResponse = storeApi(env('LIST_ITEMS'), ['company_id' => $company_id]);

        if ($partnerResponse->successful() && $gudangResponse->successful() && $apiResponse->successful() && $itemsResponse->successful()) {
            $partner = json_decode($partnerResponse->getbody()->getContents(), false);
            $gudang = json_decode($gudangResponse->getbody()->getContents(), false);
            $data = json_decode($apiResponse->getbody()->getContents(), false);
            $items = json_decode($itemsResponse->getbody()->getContents(), false);
            // dd($items, $data, $partner, $gudang);
            // $poCode = $this->generatePOCode();
            return view('penjualan.penjualan.edit', compact('items', 'partner', 'gudang', 'data'));
        } else {
            $errors = [];
            if (!$gudangResponse->successful()) {
                $errors[] = $gudangResponse->json()['message'];
            }
            if (!$partnerResponse->successful()) {
                $errors[] = $partnerResponse->json()['message'];
            }
            if (!$apiResponse->successful()) {
                $errors[] = $apiResponse->json()['message'];
            }
            return back()->withErrors($errors);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $itemsRequest = $request->input('items');
            $warehouseId = isset($itemsRequest[0]['warehouse_id']) ? (int) $itemsRequest[0]['warehouse_id'] : 0;

            $items = [];
            foreach ($itemsRequest as $itemData) {
                $entry = [
                    // 'sales_order_id' => 1,
                    'item_id' => (int) ($itemData['item_id'] ?? 0),
                    'quantity' => (int) ($itemData['quantity'] ?? 0),
                    'mutation_date' => now(),
                    'mutation_id' => 11,
                    'mutation_reason' => 'penjualan',
                    'unit_price' => (float) ($itemData['unit_price'] ?? 0),
                    'box_quantity' => $itemData['box_quantity'],
                    'per_box_quantity' => $itemData['per_box_quantity'] ?? 0,
                    'discount' => $itemData['discount'] ?? 0,
                    'notes' => ($itemData['notes'] ?? ''),
                    // 'mutation_id' => $itemData['notes'] ?? 0,
                    'uom_id' => (int) ($itemData['uom_id'] ?? 0),
                    'warehouse_id' => $warehouseId,
                    'sales_order_details_id' => 3
                ];

                $items[] = $entry;
            }

            $data = [
                "sales_id" => 1,
                // "order_number" => $request->input('order_number' ?? 1),
                "order_date" => $request->input('order_date'),
                "delivery_date" => $request->input('delivery_date'),
                'partner_id' => $request->input('partner_id'),
                'term_of_payment' => $request->input('term_of_payment'),
                'total_amount' => (float) $request->input('total_amount'),
                'coa_id' => 999,
                'payment_coa' => 0,
                'currency_id' => $request->input('currency_id'),
                'tax_rate' => $request->input('tax_rate'),
                'tax_amount' => (float) $request->input('tax_amount'),
                'sequence_number' => 10,
                'status' => 'konfirmasi',
                'description' => $request->input('description'),
                // 'company_id' => 2,
                'warehouse_id' => $warehouseId,
                'items' => $items,
            ];
            $apiResponse = updateApi(env('PENJUALAN_URL') . '/' . $id, $data);
            // dd($data, $apiResponse->json());
            if ($apiResponse->successful()) {
                // Session::put('last_po_code', $request->input('code'));
                return redirect()->route('penjualan.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $apiResponse = deleteApi(env('PENJUALAN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('penjualan.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors(
                    $apiResponse->json()['message']
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function vapprove($id)
    {
        try {
            $apiResponse = fectApi(env('PENJUALAN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                // dd($data);
                return view('penjualan.penjualan.approve', compact('data'));
            } else {
                return back()->withErrors('Gagal mengambil data item: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            $data = [
                'status' => 'Approve'
            ];
            // dd($data);
            $apiResponse = updateApi(env('PENJUALAN_URL') . '/approve/' . $id, $data);
            // dd($apiResponse);
            if ($apiResponse->successful()) {
                return redirect()->route('penjualan.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function print($id)
    {
        try {
            $apiResponse = fectApi(env('PENJUALAN_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $responseData = json_decode($apiResponse->body(), true);

                $subtotal = 0;
                $total_discount = 0;
                $total_ppn = 0;
                $total_final = 0;

                // Initialize totals array for columns that need summation
                $totals = [
                    'box_quantity' => 0,
                    'qty_in_pcs' => 0,
                    'per_box_quantity' => 0,
                    'quantity' => 0,
                    'liter_kg' => 0,
                    'pack_quantity' => 0
                ];

                if (isset($responseData['data']) && is_array($responseData['data'])) {
                    foreach ($responseData['data'] as $item) {
                        // Calculate financial totals
                        if (isset($item['quantity']) && isset($item['unit_price'])) {
                            $box_qty = $item['box_quantity'] ?? 0;
                            $qty = $item['quantity'] ?? 0;
                            $total_qty = $box_qty + $qty;

                            $subtotal_item = $total_qty * $item['unit_price'];
                            $discount_percentage = $item['discount'] ?? 0;
                            $discount_amount = $subtotal_item * ($discount_percentage / 100);

                            $ppn_rate = $item['tax_rate'] ?? 0;
                            $ppn_decimal = $ppn_rate / 100;
                            $hargapokok = $subtotal_item / (1 + $ppn_decimal);
                            $nilaippn = $subtotal_item - $hargapokok;

                            $total = $subtotal_item - $discount_amount;

                            $subtotal += $subtotal_item;
                            $total_discount += $discount_amount;
                            $total_ppn += $nilaippn;
                            $total_final += $total;
                        }

                        // Calculate column totals
                        $totals['box_quantity'] += $item['box_quantity'] ?? 0;
                        $totals['qty_in_pcs'] += $item['qty_in_pcs'] ?? 0;
                        $totals['per_box_quantity'] += $item['per_box_quantity'] ?? 0;
                        $totals['quantity'] += $item['quantity'] ?? 0;
                        $totals['liter_kg'] += isset($item['liter_kg']) ? (float) str_replace(',', '.', $item['liter_kg']) : 0;
                        $totals['pack_quantity'] += $item['pack_quantity'] ?? 0;
                    }
                }

                // Format the liter_kg total with comma as decimal separator
                $totals['liter_kg'] = number_format($totals['liter_kg'], 2, ',', '.');

                $dpp = $total_final - $total_ppn;

                $viewData = [
                    'data' => $responseData,
                    'sub_total' => $subtotal,
                    'discount' => $total_discount,
                    'dpp' => $dpp,
                    'vat' => $total_ppn,
                    'total' => $total_final,
                    'totals' => $totals
                ];

                $pdf = Pdf::loadView('penjualan.penjualan.print', $viewData);
                return $pdf->stream('invoice.pdf');
            } else {
                return back()->withErrors('Gagal mengambil data item: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

}
