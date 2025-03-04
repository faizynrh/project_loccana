<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $status = $request->input('status', 0);
            $year = $request->input('year', 0);
            $month = $request->input('month', 0);
            $search = $request->input('search.value') ?? '';
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);

            $requestbody1 = [
                'status' => "semua",
                'year' => $year,
                'month' => $month,
                'search' => $search,
                'company_id' => 2,
                'limit' => $length,
                'offset' => $start,
            ];

            $requestbody2 = [
                'status' => $status,
                'month' => $month,
                'year' => $year,
                'company_id' => 2,
            ];
            $apiResponse = storeApi(env('INVOICE_URL') . '/list', $requestbody1);
            $mtdResponse = storeApi(env('INVOICE_URL') . '/mtd', $requestbody2);
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
                'error' => $apiResponse->json()['message'],
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
    public function index()
    {
        return view('procurement.invoice.index');
    }
    public function getDODetails(Request $request, $id)
    {
        try {
            $apiResponse = fectApi(env('PENERIMAAN_BARANG_URL') . '/' . $id);
            $items = [];
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $items = [];
                foreach ($data->data as $item) {
                    $items[] = [
                        'item_id' => $item->item_id,
                        'item_name' => $item->item_name,
                        'qty' => $item->jumlah_order,
                        'unit_price' => $item->unit_price,
                        'diskon' => $item->qty_diskon,
                        'total_price' => $item->total_price,
                        'warehouse_id' => $item->warehouse_id
                    ];
                }
                return response()->json([
                    'id_item_receipt' => $data->data[0]->id_item_receipt,
                    'no_po' => $data->data[0]->code,
                    'order_date' => $data->data[0]->order_date,
                    'partner_name' => $data->data[0]->partner_name,
                    'address' => $data->data[0]->shipment_info,
                    'ppn' => $data->data[0]->ppn,
                    'receipt_date' => $data->data[0]->receipt_date,
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
        $apiResponse = fectApi(env('LIST_PENERIMAAN_BARANG') . '/' . $company_id);
        if ($apiResponse->successful()) {
            $data = json_decode($apiResponse->body());
            return view('procurement.invoice.add', compact('data'));
        } else {
            return back()->withErrors($apiResponse->json()['message']);
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
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'discount' => $item['discount'],
                        'total_price' => $item['total_price'],
                        'warehouse_id' => $item['warehouse_id'],
                    ];
                }
            }

            $data = [
                'invoice_number' => $request->invoice_number,
                'item_receipt_id' => $request->id_item_receipt,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'total_amount' => $request->total_amount,
                'tax_amount' => $request->tax_amount,
                'status' => "received",
                'company_id' => $request->input('company_id', 0),
                'items' => $dataitems
            ];

            $apiResponse = storeApi(env('INVOICE_URL'), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('invoice_pembeian.index')
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
            $apiResponse = fectApi(env('INVOICE_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('procurement.invoice.detail', compact('data'));
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
            $apiResponse = fectApi(env('INVOICE_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('procurement.invoice.edit', compact('data'));
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
                        'quantity' => $request->input('qty')[$index],
                        'unit_price' => $request->input('harga')[$index],
                        'discount' => $request->input('discount')[$index],
                        'total_price' => $request->input('total_price')[$index],
                        'warehouse_id' => $request->input('warehouse_id')[$index],
                    ];
                }
            }
            $data = [
                'invoice_number' => $request->invoice_number,
                'item_receipt_id' => $request->item_receipt_id,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'total_amount' => $request->total_amount,
                'tax_amount' => $request->tax_amount,
                'status' => "paid",
                'company_id' => 2,
                'items' => $items,
            ];
            $apiResponse = updateApi(env('INVOICE_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('invoice_pembelian.index')->with('success', $apiResponse->json()['message']);
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
            $apiResponse = deleteApi(env('INVOICE_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('invoice_pembelian.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
