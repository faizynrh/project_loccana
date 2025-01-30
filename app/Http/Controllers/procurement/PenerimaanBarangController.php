<?php

namespace App\Http\Controllers\procurement;

use Carbon\Carbon;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class PenerimaanBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $headers = Helpers::getHeaders();
                $month = $request->input('month');
                $year = $request->input('year');
                $length = $request->input('length');
                $start = $request->input('start');
                $search = $request->input('search.value') ?? '';

                $requestbody = [
                    'search' => $search,
                    'month' => $month,
                    'year' => $year,
                    'limit' => $length,
                    'offset' => $start,
                    'company_id' => 0,
                ];

                $apiurl = Helpers::getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/lists';
                $mtdurl = Helpers::getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/mtd';

                $apiResponse = Http::withHeaders($headers)->post($apiurl, $requestbody);
                $mtdResponse = Http::withHeaders($headers)->post($mtdurl, $requestbody);
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
        return view('procurement.penerimaanbarang.index');
    }
    public function getPoDetails(Request $request, $po_id)
    {
        $headers = Helpers::getHeaders();
        $apiurl = Helpers::getApiUrl() . "/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/" . $po_id;

        try {
            $response = Http::withHeaders($headers)->get($apiurl);
            $items = [];
            if ($response->successful()) {
                $data = $response->json()['data'];
                // dd($data);
                $items = [];
                foreach ($data as $item) {
                    $items[] = [
                        'item_id' => $item['item_id'],
                        'unit_price' => $item['unit_price'],
                        'warehouse_id' => $item['warehouse_id'],
                        'kode' => $item['item_code'],
                        'order_qty' => $item['item_order_qty'],
                        'balance_qty' => $item['qty_balance'],
                        'received_qty' => $item['qty_receipt'],
                        'qty' => $item['qty'],
                        'bonus_qty' => $item['qty_bonus'],
                        'deposit_qty' => $item['qty_titip'],
                        'discount' => $item['discount'],
                        'deskripsi_items' => $item['deskripsi_items'],
                    ];
                }
                return response()->json([
                    'id_po' => $data[0]['id_po'],
                    'code' => $data[0]['id_po'],
                    'order_date' => $data[0]['order_date'],
                    'principal' => $data[0]['partner_name'],
                    'address' => $data[0]['address'],
                    'description' => $data[0]['description'],
                    'phone' => $data[0]['phone'],
                    'fax' => $data[0]['fax'],
                    'gudang' => $data[0]['gudang'],
                    'items' => $items
                ]);
            }
            return response()->json(['error' => 'Failed to fetch PO details'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function create()
    {
        $company_id = 2;
        $headers = Helpers::getHeaders();

        $pourl = Helpers::getApiUrl() . '/loccana/po/1.0.0/purchase-order/list-select/' . $company_id;
        $gudangurl = Helpers::getApiUrl() . '/masterdata/warehouse/1.0.0/warehouse/list-select/' . $company_id;

        $poResponse = Http::withHeaders($headers)->get($pourl);
        $gudangResponse = Http::withHeaders($headers)->get($gudangurl);
        if ($poResponse->successful() && $gudangResponse->successful()) {
            $po = $poResponse->json()['data'];
            $gudang = $gudangResponse->json()['data'];
            // dd($po);
            // dd($gudang);
            return view('procurement.penerimaanbarang.add', compact('po', 'gudang'));
        } else {
            return back()->withErrors('Gagal mengambil data dari API.');
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0';

            $dataitems = [];

            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    $dataitems[] = [
                        'item_id' => $item['item_id'],
                        'quantity_rejected' => $item['qty_reject'],
                        'quantity_received' => $item['qty_received'],
                        'notes' => $item['note'],
                        'qty_titip' => $item['qty_titip'],
                        'qty_diskon' => $item['discount'],
                        'qty_bonus' => $item['qty_bonus'],
                        'warehouse_id' => $item['warehouse_id'],
                    ];
                }
            }

            $data = [
                'purchase_order_id' => $request->purchase_order_id,
                'do_number' => $request->do_number,
                'receipt_date' => $request->receipt_date,
                'shipment_info' => $request->shipment_info,
                'plate_number' => $request->plate_number,
                'received_by' => $request->input('received_by', 0),
                'status' => "received",
                'company_id' => $request->input('company_id', default: 2),
                'is_deleted' => 'true',
                'items' => $dataitems
            ];

            // dd($data);

            $apiResponse = Http::withHeaders($headers)->post($apiurl, $data);
            // dd([
            //     'apiResponse' => $apiResponse->json(),
            //     'data' => $data,
            // ]);
            $responseData = $apiResponse->json();
            if (
                $apiResponse->successful() &&
                isset($responseData['success'])
            ) {
                return redirect()->route('penerimaan_barang.index')
                    ->with('success', $responseData['message'] ?? 'Item Berhasil Ditambahkan');
            } else {
                return back()->withErrors(
                    'Gagal menambahkan data: ' .
                        ($responseData['message'] ?? $apiResponse->body())
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function show($id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/' . $id;
            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                // dd($data);
                return view('procurement.penerimaanbarang.detail', compact('data'));
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
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/' . $id;
            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                // dd($data);
                return view('procurement.penerimaanbarang.edit', compact('data'));
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
            // dd($request->all());
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/' . $id;
            $items = [];
            if ($request->has('item_id')) {
                foreach ($request->input('item_id') as $index => $itemId) {
                    $items[] = [
                        'item_id' => $itemId,
                        'quantity_received' => $request->input('quantity_received')[$index],
                        // 'quantity_received_old' => $request->input('quantity_received')[$index],
                        //tidak ada data
                        // 'quantity_rejected' => $request->input('quantity_rejected')[$index],
                        'notes' => $request->input('notes')[$index],
                        'qty_titip' => $request->input('qty_titip')[$index],
                        // 'qty_titip_old' => $request->input('qty_titip')[$index],
                        'qty_diskon' => $request->input('qty_diskon')[$index],
                        'qty_bonus' => $request->input('qty_bonus')[$index],
                        // 'qty_bonus_old' => $request->input('qty_bonus')[$index],
                        'warehouse_id' => $request->input('warehouse_id')[$index],
                    ];
                }
            }
            // dd($items);
            $data = [
                'do_number' => $request->do_number,
                'receipt_date' => $request->receipt_date,
                'shipment_info' => $request->shipment_info,
                'plate_number' => $request->plate_number,
                'received_by' => $request->input('received_by', 0),
                'status' => "received",
                'items' => $items,
            ];
            // dd($data);
            $apiResponse = Http::withHeaders($headers)->put($apiurl, $data);
            // dd([
            //     'apiResponse' => $apiResponse->json(),
            //     'data' => $data
            // ]);
            if ($apiResponse->successful()) {
                return redirect()->route('penerimaan_barang.index')->with('success', 'Data berhasil diperbarui!');
            } else {
                return back()->withErrors('Gagal memperbarui data: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/' . $id;
            // dd($id);
            $apiResponse = Http::withHeaders($headers)->delete($apiurl);
            if ($apiResponse->successful()) {
                return redirect()->route('penerimaan_barang.index')
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
