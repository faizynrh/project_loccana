<?php

namespace App\Http\Controllers\procurement;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Session;

class PurchaseOrderController extends Controller
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

    public function ajaxpo(Request $request)
    {
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

        if (!empty($search)) {
            $requestbody['search'] = $search;
        }

        $apiResponse = storeApi(env('PO_URL') . '/list', $requestbody);
        // $mtdurl = getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/mtd';

        if ($request->ajax()) {
            try {
                if ($apiResponse->successful()) {
                    $data = $apiResponse->json();
                    return response()->json([
                        'draw' => $request->input('draw'),
                        'recordsTotal' => $data['data']['jumlah_filter'] ?? 0,
                        'recordsFiltered' => $data['data']['jumlah'] ?? 0,
                        'data' => $data['data']['table'] ?? [],
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

    /**
     * Show the form for creating a new resource.
     */
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
            return view('procurement.purchaseorder.add', compact('partner', 'gudang','poCode'));
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


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            $itemsRequest = $request->input('items');
            $warehouseId = isset($itemsRequest[0]['warehouse_id']) ?
            (int) $itemsRequest[0]['warehouse_id'] : 0;
            $items = [];
            foreach ($itemsRequest as $itemData) {
                $items[] = (object) [
                    'item_id'      => (int) ($itemData['item_id'] ?? 0),
                    'warehouse_id' => $warehouseId,
                    // 'warehouse_id' => (int) ($itemData['warehouse_id'] ?? 0),
                    'quantity'     => (int) ($itemData['quantity'] ?? 0),
                    'unit_price'   => (float) ($itemData['unit_price'] ?? 0),
                    'discount'     => (float) ($itemData['discount'] ?? 0),
                    'uom_id'       => (int) ($itemData['uom_id'] ?? 0),
                ];
            }
            $data = (object) [
                'company_id'      => (int) $request->input('company_id', 2),
                'code'            => (string) $request->input('code'),
                "order_date" => now()->format('Y-m-d\TH:i:s\Z'),
                'partner_id'      => (int) $request->input('partner_id'),
                'term_of_payment' => (int) $request->input('term_of_payment'),
                'currency_id'     => (int) $request->input('currency_id'),
                'total_amount'    => (float) $request->input('total_amount'),
                'tax_amount'      => (float) $request->input('tax_amount'),
                'description'     => (string) $request->input('description'),
                'status'          => (string) $request->input('status'),
                'requested_by'    => (int) $request->input('requested_by'),
                'items'           => $items,
            ];

            // dd($data);

            $apiResponse = storeApi(env('PO_URL'), $data);
            // $responseData = $apiResponse->json();

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
    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        //

        try {
            $apiResponse = fectApi(env('PO_URL'). '/' . $id);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                // dd($data);
                return view('procurement.purchaseorder.detail', compact('data'));
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
        try {
            $headers = getHeaders();
            $apiurl = getApiUrl() . '/loccana/po/1.0.0/purchase-order/' . $id;
            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                // dd($data);
                return view('procurement.purchaseorder.edit', compact('data'));
            } else {
                return back()->withErrors('Gagal mengambil data item: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
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
        try {

            // $apiurl = getApiUrl() . '/loccana/po/1.0.0/purchase-order/' . $id;
            // dd($id);
            $apiResponse = deleteApi(env('PO_URL') .'/'. $id);
            if ($apiResponse->successful()) {
                return redirect()->route('purchaseorder.index')
                    ->with('success', $apiResponse->json()['message'] );
            } else {
                return back()->withErrors(
                    $apiResponse->json()['message']
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
