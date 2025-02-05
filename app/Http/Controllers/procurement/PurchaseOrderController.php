<?php

namespace App\Http\Controllers\procurement;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function generateCode()
    // {
    //     DB::beginTransaction();

    //     try {
    //         // Lock the table to prevent race conditions
    //         $lastOrder = DB::table("purchase_orders")
    //             ->lockForUpdate()
    //             ->orderBy("id", "desc")
    //             ->first();

    //         $newCode = '';

    //         if (!$lastOrder) {
    //             $newCode = 'KD00001';
    //         } else {
    //             // Get the numeric part of the code
    //             if (!preg_match('/^KD(\d{5})$/', $lastOrder->code, $matches)) {
    //                 throw new \Exception("Invalid code format found: {$lastOrder->code}");
    //             }

    //             $currentNumber = (int) $matches[1];
    //             $nextNumber = $currentNumber + 1;

    //             if ($nextNumber > 99999) {
    //                 throw new \Exception("Maximum code limit reached");
    //             }

    //             $newCode = 'KD' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    //         }

    //         // Verify the generated code is unique
    //         $codeExists = DB::table("purchase_orders")
    //             ->where('code', $newCode)
    //             ->exists();

    //         if ($codeExists) {
    //             throw new \Exception("Generated code already exists: {$newCode}");
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'code' => $newCode,
    //             'status' => 'success'
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         // Log the error with detailed information
    //         Log::error('Purchase order code generation failed', [
    //             'error' => $e->getMessage(),
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'error' => true,
    //             'message' => 'Failed to generate unique code'
    //         ], 500);
    //     }
    // }

    public function index(Request $request)
    {
        //
        $headers = Helpers::getHeaders();
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

        $apiurl = Helpers::getApiUrl() . '/loccana/po/1.0.0/purchase-order/list';
        // $mtdurl = Helpers::getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/mtd';

        if ($request->ajax()) {
            try {
                $apiResponse = Http::withHeaders($headers)->post($apiurl, $requestbody);
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

        // $mtdResponse = Http::withHeaders($headers)->post($mtdurl, $requestbody);

        // if ($mtdResponse->successful()) {
        //     $data = $mtdResponse->json()['data'];
        //     dd($data);
        //     return view('procurement.purchaseorder.index', compact('data'));
        // }
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
        $headers = Helpers::getHeaders();

        $partnerurl = Helpers::getApiUrl() . '/loccana/masterdata/partner/1.0.0/partner/list-select/' . $company_id . '/' .  $suplier . '/' . $customer;
        $gudang = Helpers::getApiUrl() . '/masterdata/warehouse/1.0.0/warehouse/list-select/' . $company_id;
        $data = [
            'company_id' => 2
        ];

        $partnerResponse = Http::withHeaders($headers)->get($partnerurl);
        $gudangResponse = Http::withHeaders($headers)->get($gudang);

        if ($partnerResponse->successful() && $gudangResponse->successful()) {
            $partner = $partnerResponse->json()['data'];
            $gudang = $gudangResponse->json()['data'];

            return view('procurement.purchaseorder.add', compact('partner', 'gudang'));
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data dari API.'
            ], 500);
        }
    }

    protected function getItemsList($company_id)
    {
        $headers = Helpers::getHeaders();
        $itemsUrl = Helpers::getApiUrl() . '/master/items/1.0.0/items/lists-select';

        $itemsResponse = Http::withHeaders($headers)->post($itemsUrl, [
            'company_id' => $company_id
        ]);

        if ($itemsResponse->successful()) {
            $items = $itemsResponse->json()['data']['items'];
            return response()->json(['items' => $items]);
        }

        return response()->json(['items' => []]);
    }


    public function getPurchaseOrderDetails(Request $request, $po_id)
    {
        $headers = Helpers::getHeaders();
        $apiurl = Helpers::getApiUrl() . "/loccana/po/1.0.0/purchase-order/" . $po_id;

        try {
            $response = Http::withHeaders($headers)->get($apiurl);
            if ($response->successful()) {
                $data = $response->json()['data'];

                $items = [];
                foreach ($data as $item) {
                    $items[] = [
                        'item_code' => $item['item_code'],
                        'price' => $item['unit_price'],
                        'order_qty' => $item['qty'],
                        'discount' => $item['discount'],
                        'received_qty' => 0,
                        'bonus_qty' => $item['total_discount'] ?? 0,
                        'total_price' => $item['total_price'],
                        'description' => $item['item_description'],
                    ];
                }

                return response()->json([
                    'id_po' => $data[0]['id_po'],
                    'code' => $data[0]['number_po'],
                    'order_date' => $data[0]['order_date'],
                    'principal' => $data[0]['partner_name'],
                    'address' => $data[0]['address'],
                    'description' => $data[0]['description'],
                    'fax' => $data[0]['fax'],
                    'email' => $data[0]['email'],
                    'ppn' => $data[0]['ppn'],
                    'term_of_payment' => $data[0]['term_of_payment'],
                    'phone' => $data[0]['phone'],
                    'items' => $items
                ]);
            }
            return response()->json(['error' => 'Failed to fetch PO details'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getprice($id)
    {
        $headers = Helpers::getHeaders();
        $apiurl = Helpers::getApiUrl() . "/loccana/po/1.0.0/purchase-order/" . $id;
        try {
            $response = Http::withHeaders($headers)->get($apiurl);
            if ($response->successful()) {
                $data = $response->json()['data'];

                $items = [];
                foreach ($data as $item) {
                    $items[] = [
                        'price' => $item['unit_price'],
                    ];
                }
            }
            return response()->json(['error' => 'Failed to fetch PO details'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        try {
            // Mengambil header dan URL API
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/po/1.0.0/purchase-order';

            // Ambil data items dari request
            $itemsRequest = $request->input('items');

            // Jika items yang dikirim hanya satu item (asosiatif) bukan array dari item,
            // bungkus ke dalam array
            if (is_array($itemsRequest) && isset($itemsRequest['item_id'])) {
                $itemsRequest = [$itemsRequest];
            }

            $items = [];
            if (is_array($itemsRequest)) {
                foreach ($itemsRequest as $itemData) {
                    // Pastikan setiap item memiliki struktur yang tepat
                    $items[] = [
                        'item_id'      => $itemData['item_id'] ?? null,
                        'warehouse_id' => $itemData['warehouse_id'] ?? null,
                        'quantity'     => $itemData['quantity'] ?? 0,
                        'unit_price'   => $itemData['unit_price'] ?? 0,
                        'discount'     => $itemData['discount'] ?? 0,
                        'uom_id'       => $itemData['uom_id'] ?? null,
                    ];
                }
            }

            // Susun data purchase order yang akan dikirim ke API
            $data = [
                'company_id'      => 2,
                'code'            => (string) $request->input('code'),
                'order_date'      => $request->input('order_date'),
                'partner_id'      => $request->input('partner_id'),
                'term_of_payment' => $request->input('term_of_payment'),
                'currency_id'     => $request->input('currency_id'),
                'total_amount'    => $request->input('total_amount'),
                'tax_amount'      => $request->input('tax_amount'),
                'description'     => $request->input('description'),
                'status'          => $request->input('status'),
                'requested_by'    => $request->input('requested_by'),
                'items'           => $items,
            ];

            // Kirim data ke API
            $apiResponse = Http::withHeaders($headers)->post($apiurl, $data);
            $responseData = $apiResponse->json();

            if ($apiResponse->successful() && isset($responseData['success']) && $responseData['success'] === true) {
                return redirect()->route('purchaseorder.index')
                    ->with('success', $responseData['message'] ?? 'Data purchase order berhasil ditambahkan.');
            } else {
                Log::error('Error saat menambahkan purchase order: ' . $apiResponse->body());
                return back()->withErrors(
                    'Gagal menambahkan data: ' . ($responseData['message'] ?? $apiResponse->body())
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
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/po/1.0.0/purchase-order/' . $id;
            $apiResponse = Http::withHeaders($headers)->get($apiurl);

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
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/po/1.0.0/purchase-order/' . $id;
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
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/po/1.0.0/purchase-order/' . $id;
            // dd($id);
            $apiResponse = Http::withHeaders($headers)->delete($apiurl);
            if ($apiResponse->successful()) {
                return redirect()->route('purchaseorder.index')
                    ->with('success', 'Data Penerimaan Barang Berhasil Dihapus!');
            } else {
                return back()->withErrors(
                    'Gagal menghapus data: ' . $apiResponse->body()
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
