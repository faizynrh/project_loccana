<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenerimaanBarangController extends Controller
{
    public function ajax(Request $request)
    {
        try {
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

            $apiResponse = storeApi(env('PENERIMAAN_BARANG_URL') . '/lists', $requestbody);
            $mtdResponse = storeApi(env('PENERIMAAN_BARANG_URL') . '/mtd', $requestbody);

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
            return response()->json([
                'error' => $apiResponse->json()['message']
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function index(Request $request)
    {
        return view('procurement.penerimaanbarang.index');
    }
    public function getPoDetails(Request $request, $id)
    {
        try {
            $apiResponse = fectApi(env('PO_URL') . '/' . $id);
            $items = [];
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $items = [];
                foreach ($data->data as $item) {
                    $items[] = [
                        'item_id' => $item->item_id,
                        'item_code' => $item->item_code,
                        'base_qty' => $item->base_qty,
                        'qty_balance' => $item->qty_balance,
                        'qty' => $item->qty,
                        'item_description' => $item->item_description,
                        'warehouse_id' => $item->warehouse_id,
                    ];
                }
                return response()->json([
                    'id_po' => $data->data[0]->id_po,
                    'order_date' => $data->data[0]->order_date,
                    'partner_name' => $data->data[0]->partner_name,
                    'address' => $data->data[0]->address,
                    'description' => $data->data[0]->description,
                    'phone' => $data->data[0]->phone,
                    'fax' => $data->data[0]->fax,
                    'warehouse_id' => $data->data[0]->warehouse_id,
                    'items' => $items
                ]);
            }
            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function create()
    {
        $company_id = 2;
        $poResponse = fectApi(env('LIST_PO') . '/' . $company_id);
        $gudangResponse = fectApi(env('LIST_GUDANG') . '/' . $company_id);
        if ($poResponse->successful() && $gudangResponse->successful()) {
            $po = $poResponse->json()['data'];
            $gudang = $gudangResponse->json()['data'];
            return view('procurement.penerimaanbarang.add', compact('po', 'gudang'));
        } else {
            $errors = [];
            if (!$poResponse->successful()) {
                $errors[] = $poResponse->json()['message'];
            }
            if (!$gudangResponse->successful()) {
                $errors[] = $gudangResponse->json()['message'];
            }
            return back()->withErrors($errors);
        }
    }

    public function store(Request $request)
    {
        try {
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
                'company_id' => $request->input('company_id', 2),
                'is_deleted' => 'true',
                'items' => $dataitems
            ];

            $apiResponse = storeApi(env('PENERIMAAN_BARANG_URL'), $data);

            if ($apiResponse->successful()) {
                return redirect()->route('penerimaan_barang.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function show($id)
    {
        try {
            $apiResponse = fectApi(env('PENERIMAAN_BARANG_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('procurement.penerimaanbarang.detail', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $apiResponse = fectApi(env('PENERIMAAN_BARANG_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                // dd($data);
                return view('procurement.penerimaanbarang.edit', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $items = [];
            if ($request->has('item_id')) {
                foreach ($request->input('item_id') as $index => $itemId) {
                    $items[] = [
                        'item_id' => $itemId,
                        'item_receipt_details_id' => $request->input('id_item_receipt_detail')[$index],
                        'quantity_received' => $request->input('qty')[$index],
                        'quantity_rejected' => $request->input('quantity_rejected')[$index],
                        'notes' => $request->input('notes')[$index],
                        'qty_titip' => $request->input('qty_titip')[$index],
                        'qty_diskon' => $request->input('qty_diskon')[$index],
                        'qty_bonus' => $request->input('qty_bonus')[$index],
                        'warehouse_id' => $request->input('warehouse_id')[$index],
                    ];
                }
            }
            $data = [
                'do_number' => $request->do_number,
                'receipt_date' => $request->receipt_date,
                'shipment_info' => $request->shipment_info,
                'plate_number' => $request->plate_number,
                'received_by' => $request->input('received_by', 1),
                'status' => "received",
                'items' => $items,
            ];
            $apiResponse = updateApi(env('PENERIMAAN_BARANG_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('penerimaan_barang.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $apiResponse = deleteApi(env('PENERIMAAN_BARANG_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('penerimaan_barang.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
