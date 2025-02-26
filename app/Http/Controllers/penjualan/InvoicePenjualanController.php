<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoicePenjualanController extends Controller
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
                'search' => $search,
                'month' => $month,
                'year' => $year,
                'company_id' => 2,
                'limit' => $length,
                'offset' => $start,
                'status' => $status,
            ];

            $requestbody2 = [
                'month' => $month,
                'year' => $year,
                'status' => $status,
                'company_id' => 2,
            ];

            $apiResponse = storeApi(env('INVOICE_PENJUALAN_URL') . '/list', $requestbody1);
            $mtdResponse = storeApi(env('INVOICE_PENJUALAN_URL') . '/mtd', $requestbody2);
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
        return view('penjualan.invoicepenjualan.index');
    }

    public function getdetails(Request $request, $id)
    {
        try {
            $apiResponse = fectApi(env('PENJUALAN_URL') . '/' . $id);
            $items = [];
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $items = [];
                foreach ($data->data as $item) {
                    $items[] = [
                        'sales_order_detail_id' => $item->sales_order_detail_id,
                        'item_id' => $item->item_id,
                        'item_code' => $item->item_code,
                        'item_name' => $item->item_name,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'per_box_quantity' => $item->per_box_quantity,
                        'discount' => $item->discount,
                        'total_price' => $item->total_price,
                        'box_quantity' => $item->box_quantity
                    ];
                }
                return response()->json([
                    'id_selling' => $data->data[0]->id_selling,
                    'order_number' => $data->data[0]->order_number,
                    'order_date' => $data->data[0]->order_date,
                    'partner_name' => $data->data[0]->partner_name,
                    'contact_info' => $data->data[0]->contact_info,
                    'tax_rate' => $data->data[0]->tax_rate,
                    'term_of_payment' => $data->data[0]->term_of_payment,
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
        $apiResponse = fectApi(env('LIST_SELLING_PENJUALAN') . '/' . $company_id);
        if ($apiResponse->successful()) {
            $data = json_decode($apiResponse->body());
            return view('penjualan.invoicepenjualan.add', compact('data'));
        } else {
            return back()->withErrors($apiResponse->json()['message']);
        }
    }

    public function store(Request $request)
    {
        try {
            $items = [];
            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    $items[] = [
                        'sales_order_detail_id' => $item['sales_order_detail_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'per_box_quantity' => $item['per_box_quantity'],
                        'discount' => $item['discount'],
                        'notes' => $item['notes'],
                        'total_amount' => $item['total_price'],
                        'box_quantity' => $item['box_quantity'],
                    ];
                }
            }

            $data = [
                'sales_order_id' => $request->id_selling,
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'notes' => $request->notes_invoice,
                'tax_invoice' => $request->tax_invoice,
                'status' => "test",
                'company_id' => 2,
                'total_amount' => $request->total_amount,
                'items' => $items
            ];
            $apiResponse = storeApi(env('INVOICE_PENJUALAN_URL'), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('invoice_penjualan.index')
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
            $apiResponse = fectApi(env('INVOICE_PENJUALAN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('penjualan.invoicepenjualan.detail', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }


    public function edit(string $id)
    {
        try {
            $apiResponse = fectApi(env('INVOICE_PENJUALAN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('penjualan.invoicepenjualan.edit', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $items = [];
            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    $items[] = [
                        'item_id' => $item['item_id'],
                        'sales_order_detail_id' => $item['sales_order_detail_id'],
                        'sales_invoice_detail_id' => $item['invoice_detail_id'],
                        'mutation_id' => $item['mutation_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'per_box_quantity' => $item['per_box_quantity'],
                        'discount' => $item['discount'],
                        'notes' => $item['notes'],
                        'total_amount' => $item['total_price'],
                        'box_quantity' => $item['box_quantity'],
                    ];
                }
            }

            $data = [
                'sales_order_id' => $request->sales_order_id,
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'notes' => $request->invoice_notes,
                'tax_invoice' => $request->tax_invoice,
                'status' => "test",
                'total_amount' => $request->total_amount,
                'items' => $items
            ];
            $apiResponse = updateApi(env('INVOICE_PENJUALAN_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('invoice_penjualan.index')
                    ->with('success', $apiResponse->json()['message']);
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
                return redirect()->route('invoice_penjualan.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
