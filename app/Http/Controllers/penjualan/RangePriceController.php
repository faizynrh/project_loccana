<?php

namespace App\Http\Controllers\penjualan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RangePriceController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'company_id' => 0,
                'limit' => $length,
                'offset' => $start,
            ];
            $apiResponse = storeApi(env('RANGE_PRICE_URL') . '/list', $requestbody);
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
        return view('penjualan.rangeprice.index');
    }
    public function edit($id)
    {
        try {
            $apiResponse = fectApi(env('RANGE_PRICE_URL') . '/' . $id);
            $data = json_decode($apiResponse->getBody()->getContents());
            return view('penjualan.rangeprice.ajax.edit', data: compact('data'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        try {

            $data = [
                'price' => $request->price,
                'valid_from' => $request->valid_from,
                'valid_to' => $request->valid_to
            ];

            $apiResponse = updateApi(env('RANGE_PRICE_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('range_price.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
