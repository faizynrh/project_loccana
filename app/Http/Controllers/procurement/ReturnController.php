<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReturnController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $year = $request->input('year', 0);
            $month = $request->input('month', 0);
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'month' => $month,
                'year' => $year,
                'company_id' => 0,
                'limit' => $length,
                'offset' => $start,
            ];

            $apiResponse = storeApi(env('RETURN_URL') . '/lists', $requestbody);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                return response()->json([
                    'draw' => $request->input('draw'),
                    'recordsTotal' => $data['data']['jumlah_filter'] ?? 0,
                    'recordsFiltered' => $data['data']['jumlah'] ?? 0,
                    'data' => $data['data'] ?? [],
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
    public function index(Request $request)
    {
        return view('procurement.return.index');
    }

    public function detailadd(Request $request, $id)
    {
        try {
            $apiResponse = fectApi(env('INVOICE_URL') . '/' . $id);
            $items = [];
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $items = [];
                foreach ($data->data as $item) {
                    $items[] = [
                        'item_id' => $item->item_id,
                        'item_code' => $item->item_code,
                        'qty_on_po' => $item->qty_on_po,
                        'unit_price' => $item->unit_price,
                        'discount' => $item->discount,
                        'total_price' => $item->total_price,
                    ];
                }
                return response()->json([
                    'id_invoice' => $data->data[0]->id_invoice,
                    'id_po' => $data->data[0]->id_po,
                    'order_date' => $data->data[0]->order_date,
                    'address' => $data->data[0]->shipment_info,
                    'ppn' => $data->data[0]->ppn,
                    'term_of_payment' => $data->data[0]->term_of_payment,
                    'status' => $data->data[0]->status,
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
        $apiResponse = fectApi(env('LIST_INVOICE') . '/' . $company_id);
        if ($apiResponse->successful()) {
            $data = json_decode($apiResponse->getBody()->getContents());
            return view('procurement.return.add', compact('data'));
        } else {
            return back()->withErrors($apiResponse->json()['message']);
        }
    }

    public function store(Request $request)
    {
        try {
            $dataitems = [];
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $dataitems[] = [
                        'item_id' => $item['item_id'],
                        'quantity' => $item['qty_retur'],
                        'notes' => $item['notes'],
                    ];
                }
            }

            $data = [
                'purchase_order_id' => $request->id_po,
                'invoice_id' => $request->id_invoice,
                'return_date' => $request->return_date,
                'reason' => $request->keterangan_retur,
                'status' => "return",
                'company_id' => $request->input('company_id', 2),
                'items' => $dataitems
            ];
            $apiResponse = storeApi(env('RETURN_URL'), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('return.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $apiResponse = fectApi(env('RETURN_URL') . '/' . $id);
            $data = json_decode($apiResponse->getBody()->getContents());
            return view('procurement.return.detail', compact('data'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        try {
            $items = [];
            if ($request->has('item_id')) {
                foreach ($request->input('item_id') as $index => $itemId) {
                    $items[] = [
                        'item_id' => $itemId,
                        'quantity' => $request->input('quantity')[$index],
                        'notes' => $request->input('notes')[$index],
                    ];
                }
            }
            $data = [
                'return_date' => $request->return_date,
                'reason' => $request->reason,
                'status' => "received",
                'company_id' => $request->input('company_id', 2),
                'items' => $items
            ];
            $apiResponse = updateApi(env('RETURN_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('return.index')->with('success', $apiResponse->json()['message']);
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
            $apiResponse = deleteApi(env('RETURN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('return.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
