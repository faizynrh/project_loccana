<?php

namespace App\Http\Controllers\masterdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\Helpers;



class PriceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $headers = Helpers::getHeaders();
                $apiurl = Helpers::getApiUrl() . '/masterdata/price/1.0.0/price-manajement/list';

                $length = $request->input('length', 10);
                $start = $request->input('start', 0);
                $search = $request->input('search.value', '');

                $requestbody = [
                    'limit' => $length,
                    'offset' => $start,
                    'company_id' => 2
                ];

                if (!empty($search)) {
                    $requestbody['search'] = $search;
                }
                $apiResponse = Http::withHeaders($headers)->post($apiurl, $requestbody);
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
                    'error' => 'Failed to fetch data',
                ], 500);
            } catch (\Exception $e) {
                if ($request->ajax()) {
                    return response()->json([
                        'error' => $e->getMessage(),
                    ], 500);
                }
            }
        }

        return view('masterdata.price.index');
    }

    public function edit($id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/masterdata/price/1.0.0/price-manajement/' . $id;
            $apiResponse = Http::withHeaders($headers)->get($apiurl);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                return view('masterdata.price.edit', compact('data', 'id'));
            } else {
                return back()->withErrors('Gagal mengambil data Price: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/masterdata/price/1.0.0/price-manajement/' . $id;

            $data = [
                'harga_atas' => $request->harga_atas ?? 0,
                'harga_bawah' => $request->harga_bawah ?? 0,
                'harga_pokok' => $request->harga_pokok ?? 0,
                'harga_beli' => $request->harga_beli ?? 0,
            ];

            $apiResponse = Http::withHeaders($headers)->put($apiurl, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('price.index')->with('success', 'Data Price berhasil diperbarui!');
            } else {
                return back()->withErrors('Gagal memperbarui data Price: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/masterdata/price/1.0.0/price-manajement/approve/' . $id;

            $data = [
                'status' => 'approve',
            ];

            $apiResponse = Http::withHeaders($headers)->put($apiurl, $data);

            if ($apiResponse->successful()) {
                $title = 'Delete User!';
                $text = "Are you sure you want to delete?";
                confirmDelete($title, $text);
                return redirect()->route('price.index')->with('success', 'Data Berhasil Disetujui!');
            } else {
                return back()->withErrors('Gagal Approve Price: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
