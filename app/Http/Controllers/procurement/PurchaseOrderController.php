<?php

namespace App\Http\Controllers\procurement;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $headers = Helpers::getHeaders();
        $month = $request->input('month', 11);
        $year = $request->input('year', 0);
        $length = $request->input('length', 10);
        $start = $request->input('start', 0);

        // Log::info($month);
        // Log::info($year);
        // Log::info($length);
        // Log::info($start);


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
        //
        $company_id = 2;
        $headers = Helpers::getHeaders();

        $pourl = Helpers::getApiUrl() . '/loccana/po/1.0.0/purchase-order/list-select/' . $company_id;

        $poResponse = Http::withHeaders($headers)->get($pourl);
        if ($poResponse->successful()) {
            $po = $poResponse->json()['data'];
            // dd($po);
            // dd($gudang);
            return view('procurement.purchaseorder.add', compact('po'));
        } else {
            return back()->withErrors('Gagal mengambil data dari API.');
        }
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


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

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
