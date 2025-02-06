<?php

namespace App\Http\Controllers\masterdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class PriceController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'limit' => $length,
                'offset' => $start,
                'company_id' => 2
            ];

            $apiResponse = storeApi(env('PRICE_URL') . '/list', $requestbody);
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
                'error' => $apiResponse->status(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function index(Request $request)
    {
        return view('masterdata.price.index');
    }

    public function edit($id)
    {
        try {
            $apiResponse = fectApi(env('PRICE_URL') . '/' . $id);
            $data = json_decode($apiResponse->getBody()->getContents());
            return view('masterdata.price.ajax.edit', data: compact('data'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = [
                'harga_atas' => $request->harga_atas,
                'harga_bawah' => $request->harga_bawah,
                'harga_pokok' => $request->harga_pokok,
                'harga_beli' => $request->harga_beli,
            ];

            $apiResponse = updateApi(env('PRICE_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('price.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            $data = [
                'status' => 'approve',
            ];
            $apiResponse = updateApi(env('PRICE_URL') . '/approve/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('price.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
