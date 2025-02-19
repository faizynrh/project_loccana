<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInventoryStockInTransit;

class StockInTransitController extends Controller
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
            $apiResponse = storeApi(env('STOCK_IN_TRANSIT_URL') . '/lists', $requestbody);
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
        return view('inventory.stockintransit.index');
    }

    public function create()
    {
        $company_id = 2;
        $requestbody = [
            'company_id' => $company_id,
        ];
        $itemResponse = storeApi(env('LIST_ITEMS'), $requestbody);
        if ($itemResponse->successful()) {
            $item = json_decode($itemResponse->body());
            $items = $item->data->items;
            return view('inventory.stockintransit.add', compact('items'));
        } else {
            return back()->withErrors($itemResponse->json()['message']);
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $dataitems = [];
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $dataitems[] = [
                        'item_id' => $item['item_id'],
                        'quantity_rejected' => $item['qty_reject'],
                        'quantity_received' => $item['qty_received'],
                        'notes' => $item['item_description'],
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

    public function show(string $id)
    {
        try {
            $apiResponse = fectApi(env('STOCK_IN_TRANSIT_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('inventory.stockintransit.detail', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $start_date = $request->input('start_date', 0);
            $end_date = $request->input('end_date', 0);

            $requestbody = [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'company_id' => 0,
            ];

            $apiResponse = storeApi(env('STOCK_IN_TRANSIT_URL') . '/lists', $requestbody);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data']['table'] ?? [];
                // dd($data);
                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }

                return Excel::download(new ExportInventoryStockInTransit($data, $start_date, $end_date), 'Laporan Stock In Transit.xlsx');
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
