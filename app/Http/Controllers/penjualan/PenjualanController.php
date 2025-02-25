<?php

namespace App\Http\Controllers\penjualan;

use App\Http\Controllers\Controller;
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
            $partner = $partnerResponse->json()['data'];
            $gudang = $gudangResponse->json()['data'];
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
    // protected function getgudang($company_id)
    // {
    //     $apiUrl = env('LIST_GUDANG');
    //     $response = storeApi($apiUrl, ['company_id' => $company_id]);

    //     if ($response->successful()) {
    //         $warehouses = $response->json()['data'] ?? [];

    //         return response()->json([
    //             'success' => true,
    //             'data' => $warehouses
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'data' => []
    //     ]);
    // }
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
                    'per_box_quantity' => $itemData['per_box_quantity'],
                    'discount' => (float) ($itemData['discount'] ?? 0),
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
                'tax_rate' => 1,
                'tax_amount' => (float) $request->input('tax_amount'),
                'sequence_number' => 10,
                'status' => 'diterima',
                'description' => $request->input('description'),
                'company_id' => 2,
                'warehouse_id' => $warehouseId,
                'items' => $items,
            ];
            $apiResponse = storeApi(env('PENJUALAN_URL'), $data);
            dd($apiResponse->json(), $data);
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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
