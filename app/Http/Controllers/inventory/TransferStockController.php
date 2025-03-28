<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransferStockController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $start_date = $request->input('start_date', 0);
            $end_date = $request->input('end_date', 0);
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'company_id' => 0,
                'limit' => $length,
                'offset' => $start,
            ];
            $apiResponse = storeApi(env('TRANSFER_STOCK_URL') . '/lists', $requestbody);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json();

                return response()->json([
                    'draw' => $request->input('draw'),
                    'recordsTotal' => $data['data']['jumlah_filter'] ?? 0,
                    'recordsFiltered' => $data['data']['jumlah'] ?? 0,
                    'data' => $data['data']['table'] ?? [],
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

        return view('inventory.transferstock.index');
    }

    public function create()
    {
        $company_id = 2;
        $requestbody = [
            'company_id' => $company_id,
        ];
        $gudangResponse = fectApi(env('LIST_GUDANG') . '/' . $company_id);
        $itemResponse = storeApi(env('LIST_ITEMS'), $requestbody);
        if ($gudangResponse->successful() && $itemResponse->successful()) {
            $gudang = json_decode($gudangResponse->body());
            $item = json_decode($itemResponse->body());
            $gudangs = $gudang->data;
            $items = $item->data->items;
            return view('inventory.transferstock.add', compact('gudangs', 'items'));
        } else {
            return redirect()->route('stock_gudang.index')->withErrors(
                $gudangResponse->json()['message'] ?? 'Terjadi kesalahan, silakan coba lagi.'
            );
        }
    }

    public function store(Request $request)
    {
        try {
            $dataitems = [];
            if ($request->has('id_item')) {
                foreach ($request->input('id_item') as $index => $item_id) {
                    $dataitems[] = [
                        'item_id' => $item_id,
                        'quantity' => $request->qty[$index],
                    ];
                }
            }

            $data = [
                'from_warehouse_id' => $request->sumber_gudang[0],
                'to_warehouse_id' => $request->target_gudang[0],
                'transfer_date' => $request->transfer_date,
                'status' => "transfer",
                'transfer_reason' => $request->transfer_reason,
                'company_id' => 2,
                'items' => $dataitems
            ];

            $apiResponse = storeApi(env('TRANSFER_STOCK_URL'), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('transfer_stock.index')
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
            $apiResponse = fectApi(env('TRANSFER_STOCK_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $datas = $data->data;
                return view('inventory.transferstock.detail', compact('datas'));
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
            $company_id = 2;
            $requestbody = [
                'company_id' => $company_id,
            ];
            $gudangResponse = fectApi(env('LIST_GUDANG') . '/' . $company_id);
            $itemResponse = storeApi(env('LIST_ITEMS'), $requestbody);
            $apiResponse = fectApi(env('TRANSFER_STOCK_URL') . '/' . $id);
            if ($apiResponse->successful() && $gudangResponse->successful() && $itemResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $gudang = json_decode($gudangResponse->body());
                $item = json_decode($itemResponse->body());
                $datas = $data->data;
                $gudangs = $gudang->data;
                $items = $item->data->items;
                return view('inventory.transferstock.edit', compact('datas', 'gudangs', 'items'));
            } else {
                $errors = [];
                if (!$apiResponse->successful()) {
                    $errors[] = ($apiResponse->json()['message']);
                }

                if (!$gudangResponse->successful()) {
                    $errors[] =  ($gudangResponse->json()['message']);
                }

                if (!$itemResponse->successful()) {
                    $errors[] =  ($itemResponse->json()['message']);
                }

                return back()->withErrors(implode(' | ', $errors));
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $dataitems = [];
            if ($request->has('id_item')) {
                foreach ($request->input('id_item') as $index => $item_id) {
                    $dataitems[] = [
                        'item_id' => $item_id,
                        'quantity' => $request->qty[$index],
                    ];
                }
            }

            $data = [
                'from_warehouse_id' => $request->sumber_gudang[0],
                'to_warehouse_id' => $request->target_gudang[0],
                'transfer_date' => $request->transfer_date,
                'status' => "transfer",
                'transfer_reason' => $request->transfer_reason,
                'company_id' => 2,
                'items' => $dataitems
            ];
            $apiResponse = updateApi(env('TRANSFER_STOCK_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('transfer_stock.index')->with('success', $apiResponse->json()['message']);
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
            $apiResponse = deleteApi(env('TRANSFER_STOCK_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('transfer_stock.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function print($id)
    {
        try {
            $apiResponse = fectApi(env('TRANSFER_STOCK_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $datas = $data->data;
                $pdf = Pdf::loadView('inventory.transferstock.print', compact('datas'));
                return $pdf->stream('Transfer Stok ' . $datas[0]->gudang_asal . ' ke ' . $datas[0]->gudang_tujuan . ' ' . $datas[0]->transfer_date . '.pdf');
            } else {
                return back()->withErrors($apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
