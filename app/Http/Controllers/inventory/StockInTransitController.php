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
        try {
            $items = [];
            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    $items[] = [
                        'item_id' => $item['item_id'],
                        'qty_box' => $item['qty_box'],
                        'total_qty_box' => $item['total_qty_box'],
                    ];
                }
            }

            $data = [
                'transit_date' => $request->transit_date,
                'sales' => $request->sales,
                'keretangan_transit' => $request->description,
                'items' => $items
            ];
            $apiResponse = storeApi(env('STOCK_IN_TRANSIT_URL'), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('stock_in_transit.index')
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
            $length = $request->input('total_entries');

            $requestbody = [
                'search' => '',
                'start_date' => $start_date,
                'end_date' => $end_date,
                'company_id' => 0,
                'limit' => $length,
                'offset' => 0,
            ];
            $apiResponse = storeApi(env('STOCK_IN_TRANSIT_URL') . '/lists', $requestbody);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data']['table'] ?? [];
                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }
                $fileName = 'Laporan Stock In Transit ' . $start_date . ' s.d ' . $end_date . '.xlsx';
                return Excel::download(new ExportInventoryStockInTransit($data, $start_date, $end_date), $fileName);
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
