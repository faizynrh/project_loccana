<?php

namespace App\Http\Controllers\inventory;

use App\Exports\ExportInventoryStock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class StockController extends Controller
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
            $apiResponse = storeApi(env('STOCK_URL') . '/lists', $requestbody);
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
        return view('inventory.stock.index');
    }

    public function show($id)
    {
        try {
            $apiResponse = fectApi(env('STOCK_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('inventory.stock.detail', compact('data'));
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
            $apiResponse = fectApi(env('STOCK_URL') . '/' . $id);
            $data = json_decode($apiResponse->getBody()->getContents());
            return view('inventory.stock.ajax.mutasi', data: compact('data'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'item_id' => $request->item_id,
                'quantity' => $request->qty,
                'date_mutation' => $request->date_mutation,
                'mutation_reason' => $request->mutation_reason,
            ];

            $apiResponse = storeApi(env('STOCK_URL') . '/mutasi', $data);
            if ($apiResponse->successful()) {
                return redirect()->route('stock.index')->with('success', $apiResponse->json()['message']);
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

            $apiResponse = storeApi(env('STOCK_URL') . '/lists', $requestbody);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data']['table'] ?? [];

                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }

                return Excel::download(new ExportInventoryStock($data, $start_date, $end_date), 'Inventory Stock.xlsx');
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
