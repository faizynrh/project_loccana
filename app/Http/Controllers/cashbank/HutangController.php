<?php

namespace App\Http\Controllers\cashbank;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class HutangController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $status = $request->input('status', 0);
            $month = $request->input('month', 0);
            $year = $request->input('year', 0);
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'status' => $status,
                'month' => $month,
                'year' => $year,
                'limit' => $length,
                'offset' => $start,
            ];
            $apiResponse = storeApi(env('HUTANG_URL') . '/hutang/list', $requestbody);
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

    public function ajaxpembayaran(Request $request)
    {
        try {
            $status = $request->input('status', 0);
            $month = $request->input('month', 0);
            $year = $request->input('year', 0);
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'status' => $status,
                'month' => $month,
                'year' => $year,
                'limit' => $length,
                'offset' => $start,
            ];
            $apiResponse = storeApi(env('HUTANG_URL') . '/hutang/pembayaran/list', $requestbody);
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
        return view('cashbank.hutang.index');
    }

    public function showhutang(string $id)
    {
        try {
            $apiResponse = fectApi(env('HUTANG_URL') . '/hutang_invoice/detail/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('cashbank.hutang.detailhutang', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function pembayaran()
    {
        return view('cashbank.hutang.pembayaran');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
