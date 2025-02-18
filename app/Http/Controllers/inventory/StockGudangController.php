<?php

namespace App\Http\Controllers\inventory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class StockGudangController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $start_date = $request->input('start_date', 0);
            $end_date = $request->input('end_date', 0);
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';
            $warehouse = $request->input('warehouseid') ?? '';

            $requestbody = [
                'search' => $search,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'company_id' => 0,
                'limit' => $length,
                'offset' => $start,
            ];

            $apiResponse = storeApi(env('STOCK_GUDANG_URL') . '/lists', $requestbody);
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
    public function index(Request $request)
    {
        $company_id = 2;
        $apiResponse = fectApi(env('LIST_GUDANG') . '/' . $company_id);
        if ($apiResponse->successful()) {
            $data = json_decode($apiResponse->body());
            return view('inventory.stockgudang.index', compact('data'));
        } else {
            return redirect()->route('stock_gudang.index')->withErrors(
                $apiResponse->json()['message'] ?? 'Terjadi kesalahan, silakan coba lagi.'
            );
        }
    }

    public function show($id)
    {
        return view('inventory.stockgudang.detail');
        // try {
        //     $apiResponse = fectApi(env('STOCK_URL') . '/' . $id);
        //     if ($apiResponse->successful()) {
        //         $data = json_decode($apiResponse->body());
        //         return view('inventory.stockgudang.detail', compact('data'));
        //     } else {
        //         return back()->withErrors($apiResponse->json()['message']);
        //     }
        // } catch (\Exception $e) {
        //     return back()->withErrors($e->getMessage());
        // }
    }
}
