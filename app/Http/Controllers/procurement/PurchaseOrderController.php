<?php

namespace App\Http\Controllers\procurement;

use App\Exports\ExportProcurementPurchaseOrderDetail;
use App\Http\Controllers\Controller;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportProcurementPurchaseOrder;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //  Sementara
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
    protected function getDetailWarehouse($id)
    {
        try {
            $warehouseResponse = fectApi(env('GUDANG_URL') . '/' . $id);

            if ($warehouseResponse->successful()) {
                $warehouse = json_decode($warehouseResponse->getbody()->getContents(), false);

                return response()->json([
                    'location' => $warehouse->data->location ?? null
                ]);
            } else {
                return response()->json(['message' => 'Gagal mengambil data'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan pada server'], 500);
        }
    }
    protected function getDetailPrinciple($id)
    {
        try {
            $contact_info = fectApi(env('PARTNER_URL') . '/' . $id);

            if ($contact_info->successful()) {
                $contact = json_decode($contact_info->getbody()->getContents(), false);

                return response()->json([
                    'contact_info' => $contact->data->contact_info ?? null
                ]);
            } else {
                return response()->json(['message' => 'Gagal mengambil data'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan pada server'], 500);
        }
    }

    protected function getprice($id)
    {
        try {
            $price = fectApi(env('PRICE_URL') . '/' . $id);

            if ($price->successful()) {
                $contact = json_decode($price->getbody()->getContents(), false);

                return response()->json([
                    'price' => $contact->data->price ?? null
                ]);
            } else {
                return response()->json(['message' => 'Gagal mengambil data'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan pada server'], 500);
        }
    }

    public function print($id)
    {
        try {
            $apiResponse = fectApi(env('PO_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $responseData = json_decode($apiResponse->body(), true);

                $subtotal = 0;
                $total_discount = 0;
                // dd($responseData);

                if (isset($responseData['data']) && is_array($responseData['data'])) {
                    foreach ($responseData['data'] as $item) {
                        if (isset($item['qty']) && isset($item['unit_price'])) {
                            $subtotal += $item['qty'] * $item['unit_price'];
                            // Pastikan item memiliki field discount sebelum menghitung
                            $discount_percentage = isset($item['discount']) ? $item['discount'] : 0;
                            $total_discount += ($item['qty'] * $item['unit_price']) * ($discount_percentage / 100);
                        }
                    }
                }

                $taxable = $subtotal - $total_discount;

                $ppn_rate = $responseData['data'][0]['ppn'];
                $ppn = ($taxable * $ppn_rate) / 100;
                $total = $taxable + $ppn;

                $viewData = [
                    'data' => $responseData,
                    'sub_total' => $subtotal,
                    'discount' => $total_discount,
                    'taxable' => $taxable,
                    'vat' => $ppn,
                    'total' => $total,
                    'notes' => $responseData['notes'] ?? '',
                    'purchase_date' => $responseData['purchase_date'] ?? date('Y-m-d'),
                    'approved_by' => $responseData['approved_by'] ?? '',
                    'checked_by' => $responseData['checked_by'] ?? '',
                    'ordered_by' => $responseData['ordered_by'] ?? ''
                ];

                $pdf = Pdf::loadView('procurement.purchaseorder.print', $viewData);
                return $pdf->stream('Purchase_Order.pdf');
            } else {
                return back()->withErrors('Gagal mengambil data item: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function ajaxpo(Request $request)
    {
        $search = $request->input('search.value') ?? '';
        $month = $request->input('month', 11);
        $year = $request->input('year', 0);
        $length = $request->input('length', 10);
        $start = $request->input('start', 0);

        $requestbody = [
            'search' => '',
            'month' => $month,
            'year' => $year,
            'limit' => $length,
            'offset' => $start,
            'company_id' => 2,
        ];

        $payloadmtd = [
            'month' => $month,
            'year' => $year,
            'company_id' => 2,
        ];

        if (!empty($search)) {
            $requestbody['search'] = $search;
        }

        $apiResponse = storeApi(env('PO_URL') . '/list', $requestbody);
        $mtdResponse = storeApi(env('PO_URL') . '/mtd', $payloadmtd);

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
        return view("procurement.purchaseorder.index");
    }
    public function create()
    {
        $company_id = 2;
        $customer = 'false';
        $suplier = 'true';
        $data = [
            'company_id' => 2
        ];

        $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $company_id . '/' . $suplier . '/' . $customer);
        $gudangResponse = fectApi(env('LIST_GUDANG') . '/' . $company_id);

        if ($partnerResponse->successful() && $gudangResponse->successful()) {
            $partner = $partnerResponse->json()['data'];
            $gudang = $gudangResponse->json()['data'];
            $poCode = $this->generatePOCode();
            return view('procurement.purchaseorder.add', compact('partner', 'gudang', 'poCode'));
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
    public function store(Request $request)
    {
        try {
            $itemsRequest = $request->input('items');
            $warehouseId = isset($itemsRequest[0]['warehouse_id']) ?
                (int) $itemsRequest[0]['warehouse_id'] : 0;
            $items = [];
            foreach ($itemsRequest as $itemData) {
                $items[] = (object) [
                    'item_id' => (int) ($itemData['item_id'] ?? 0),
                    'warehouse_id' => $warehouseId,
                    'quantity' => (int) ($itemData['quantity'] ?? 0),
                    'unit_price' => (float) ($itemData['unit_price'] ?? 0),
                    // 'total_price' => (float) ($itemData['total_price'] ?? 0),
                    'discount' => (float) ($itemData['discount'] ?? 0),
                    'uom_id' => (int) ($itemData['uom_id'] ?? 0),

                ];
            }
            $data = (object) [
                'company_id' => (int) $request->input('company_id', 2),
                'code' => (string) $request->input('code'),
                "order_date" => now()->format('Y-m-d\TH:i:s\Z'),
                'partner_id' => (int) $request->input('partner_id'),
                'term_of_payment' => $request->input('term_of_payment'),
                'currency_id' => (int) $request->input('currency_id'),
                'total_amount' => (float) $request->input('total_amount'),
                'tax_amount' => (float) $request->input('tax_amount'),
                'ppn' => $request->input('ppn'),
                'description' => (string) $request->input('description'),
                'status' => (string) $request->input('status'),
                'requested_by' => (int) $request->input('requested_by'),
                'items' => $items,
            ];

            // dd($data);

            $apiResponse = storeApi(env('PO_URL'), $data);
            if ($apiResponse->successful()) {
                Session::put('last_po_code', $request->input('code'));
                return redirect()->route('purchaseorder.index')
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
    public function show(string $id)
    {
        //
        $company_id = 2;
        try {
            $apiResponse = fectApi(env('PO_URL') . '/' . $id);
            $gudangResponse = fectApi(env('LIST_GUDANG') . '/' . $company_id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $gudang = json_decode($gudangResponse->getbody()->getContents(), false);


                // dd($data);
                return view('procurement.purchaseorder.detail', compact('data', 'gudang'));
            } else {
                return back()->withErrors('Gagal mengambil data item: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

    }
    public function edit(string $id)
    {
        try {
            $company_id = 2;
            $customer = 'false';
            $suplier = 'true';
            $data = [
                'company_id' => 2
            ];
            $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $company_id . '/' . $suplier . '/' . $customer);
            $gudangResponse = fectApi(env('LIST_GUDANG') . '/' . $company_id);
            $apiResponse = fectApi(env('PO_URL') . '/' . $id);
            $itemsResponse = storeApi(env('LIST_ITEMS'), ['company_id' => $company_id]);

            if ($apiResponse->successful() && $gudangResponse->successful() && $partnerResponse->successful() && $itemsResponse->successful()) {
                $data = json_decode($apiResponse->getBody()->getContents(), false);
                $gudang = json_decode($gudangResponse->getbody()->getContents(), false);
                $partner = json_decode($partnerResponse->getbody()->getContents(), false);
                $items = json_decode($itemsResponse->getbody()->getContents(), false);
                // dd($gudang, $partner, $data);
                return view('procurement.purchaseorder.edit', compact('data', 'gudang', 'partner', 'items'));
            } else {
                return back()->withErrors('Gagal mengambil data item: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $itemsRequest = $request->input('items');
            $warehouseId = isset($itemsRequest[0]['warehouse_id']) ? (int) $itemsRequest[0]['warehouse_id'] : 0;

            $items = [];
            foreach ($itemsRequest as $itemData) {
                $entry = [
                    'item_id' => (int) ($itemData['item_id'] ?? 0),
                    'warehouse_id' => $warehouseId,
                    'quantity' => (int) ($itemData['quantity'] ?? 0),
                    'unit_price' => (float) ($itemData['unit_price'] ?? 0),
                    'discount' => (float) ($itemData['discount'] ?? 0),
                    'uom_id' => (int) ($itemData['uom_id']),
                    'po_detail_id' => isset($itemData['po_detail_id']) ? (int) $itemData['po_detail_id'] : 0
                ];

                $items[] = $entry;
            }

            $data = [
                "order_date" => $request->input('order_date'),
                'partner_id' => $request->input('partner_id'),
                'term_of_payment' => $request->input('term_of_payment'),
                'currency_id' => (int) $request->input('currency_id'),
                'total_amount' => (float) $request->input('total_amount'),
                'tax_amount' => (float) $request->input('tax_amount'),
                'description' => (string) $request->input('description'),
                'status' => (string) $request->input('status'),
                'requested_by' => (int) $request->input('requested_by'),
                'items' => $items,
            ];
            // dd($data);
            $apiResponse = updateApi(env('PO_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                Session::put('last_po_code', $request->input('code'));
                return redirect()->route('purchaseorder.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function destroy(string $id)
    {
        try {
            $apiResponse = deleteApi(env('PO_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('purchaseorder.index')
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
    public function vapprove(string $id)
    {
        $company_id = 2;
        try {
            $apiResponse = fectApi(env('PO_URL') . '/' . $id);
            $gudangResponse = fectApi(env('LIST_GUDANG') . '/' . $company_id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $gudang = json_decode($gudangResponse->getbody()->getContents(), false);

                // dd($data);
                return view('procurement.purchaseorder.approve', compact('data', 'gudang'));
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
                'approved_by' => 1,
                'status' => 'Approve'
            ];
            // dd($data);
            $apiResponse = updateApi(env('PO_URL') . '/approve/' . $id, $data);
            // dd($apiResponse);
            if ($apiResponse->successful()) {
                return redirect()->route('purchaseorder.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function reject(Request $request, $id)
    {
        try {
            $data = [
                'approved_by' => 1,
                'status' => 'Reject'
            ];
            // dd($data);
            $apiResponse = updateApi(env('PO_URL') . '/approve/' . $id, $data);
            // dd($apiResponse);
            if ($apiResponse->successful()) {
                return redirect()->route('purchaseorder.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function exportExcel(Request $request)
    {
        try {
            $month = $request->input('month', 0);
            $year = $request->input('year', now()->year);
            $total_entries = $request->input('total_entries');

            // Make sure we have a reasonable number for limit
            $limit = intval($total_entries) > 0 ? intval($total_entries) : 1000;

            $requestbody = [
                'search' => $request->input('search', ''),
                'month' => $month,
                'year' => $year,
                'limit' => $limit, // Use the filtered entries count
                'offset' => 0,
                'company_id' => 2,
            ];

            $apiResponse = storeApi(env('PO_URL') . '/' . 'list', $requestbody);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                $tableData = $data['data']['table'];

                if (empty($tableData)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }

                // Passing the data to the ExportProcurementReport class
                return Excel::download(new ExportProcurementPurchaseOrder($tableData, $month, $year), 'Purchase Order.xlsx');
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function exportExcelDetail(string $id)
    {
        try {
            $apiResponse = fectApi(env('PO_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $response = $apiResponse->json();
                $data = $response['data'];
                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }
                $po = $data[0]['number_po'] ?? 'data tidak masuk';
                $name_principle = $data[0]['partner_name'] ?? 'data tidak masuk';
                // dd($data);
                return Excel::download(new ExportProcurementPurchaseOrderDetail($data), $po . ' - ' . $name_principle . '.xlsx');
                // return Excel::download(new ExportProcurementPurchaseOrderDetail($data), "{$data['partner_name']}.xlsx");
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
