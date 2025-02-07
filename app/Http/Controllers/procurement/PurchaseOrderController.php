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
            return view('procurement.purchaseorder.add', compact('partner', 'gudang'));
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

    protected function getItemsList()
    {
        $apiResponse = fectApi(env('LIST_ITEMS'));
        if ($apiResponse->successful()) {
            $items = $apiResponse->json()['data']['items'];
            return response()->json(['items' => $items]);
        }
        return response()->json(['items' => []]);
    }


    public function getprice($id)
    {
        try {
            $apiResponse = fectApi(env('PO_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
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
            $headers = getHeaders();
            $apiurl = getApiUrl() . '/loccana/po/1.0.0/purchase-order';

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
                        'item_id' => $itemData['item_id'] ?? null,
                        'warehouse_id' => $itemData['warehouse_id'] ?? null,
                        'quantity' => $itemData['quantity'] ?? 0,
                        'unit_price' => $itemData['unit_price'] ?? 0,
                        'discount' => $itemData['discount'] ?? 0,
                        'uom_id' => $itemData['uom_id'] ?? null,
                    ];
                }
            }

            // Susun data purchase order yang akan dikirim ke API
            $data = [
                'company_id' => 2,
                'code' => (string) $request->input('code'),
                'order_date' => $request->input('order_date'),
                'partner_id' => $request->input('partner_id'),
                'term_of_payment' => $request->input('term_of_payment'),
                'currency_id' => $request->input('currency_id'),
                'total_amount' => $request->input('total_amount'),
                'tax_amount' => $request->input('tax_amount'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'requested_by' => $request->input('requested_by'),
                'items' => $items,
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
            $headers = getHeaders();
            $apiurl = getApiUrl() . '/loccana/po/1.0.0/purchase-order/' . $id;
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
            $headers = getHeaders();
            $apiurl = getApiUrl() . '/loccana/po/1.0.0/purchase-order/' . $id;
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
