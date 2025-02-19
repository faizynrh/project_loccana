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
                    'data' => $data['data']['table'][0] ?? [],
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
        $supplier = "false";
        $customer = "true";
        $requestbody = [
            'company_id' => $company_id,
        ];
        $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $company_id . '/' . $supplier . '/' . $customer);
        $itemResponse = storeApi(env('LIST_ITEMS'), $requestbody);
        if ($partnerResponse->successful()) {
            $partner = json_decode($partnerResponse->body());
            $item = json_decode($itemResponse->body());
            $items = $item->data->items;
            // dd($items);
            return view('inventory.stockintransit.add', compact('partner', 'items'));
        } else {
            return back()->withErrors($partnerResponse->json()['message']);
        }
    }

    public function store(Request $request)
    {
        //
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
                $data = $apiResponse->json()['data']['table'][0] ?? [];
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
