<?php

namespace App\Http\Controllers\masterdata;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class GudangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $headers = Helpers::getHeaders();
                $apiurl = Helpers::getApiUrl() . '/masterdata/warehouse/1.0.0/warehouse/lists';

                $length = $request->input('length', 10);
                $start = $request->input('start', 0);
                $search = $request->input('search.value') ?? '';

                $requestbody = [
                    'search' => $search,
                    'limit' => $length,
                    'offset' => $start,
                    'company_id' => 2
                ];

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

        return view('masterdata.gudang.index');
    }

    public function create()
    {
        return view('masterdata.gudang.add');
    }
    public function store(Request $request)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/masterdata/warehouse/1.0.0/warehouse';

            $data = [
                'name' => $request->input('name'),
                'location' => $request->input('location'),
                'company_id' => $request->input('company_id', 2),
                'description' => $request->input('description'),
                'capacity' => $request->input('capacity', 0),
            ];

            $apiResponse = Http::withHeaders($headers)->post($apiurl, $data);

            $responseData = $apiResponse->json();
            if (
                $apiResponse->successful() &&
                isset($responseData['success'])
            ) {
                return redirect()->route('gudang.index')
                    ->with('success', $responseData['message'] ?? 'Gudang Berhasil Ditambahkan');
            } else {
                return back()->withErrors(
                    'Gagal menambahkan data: ' .
                        ($responseData['message'] ?? $apiResponse->body())
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
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
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/masterdata/warehouse/1.0.0/warehouse/' . $id;

            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                return view('masterdata.gudang.edit', compact('data', 'id'));
            } else {
                return back()->withErrors('Gagal mengambil data COA: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/masterdata/warehouse/1.0.0/warehouse/' . $id;

            $data = [
                'name' => $request->name,
                'location' => $request->location,
                'description' => $request->description,
                'capacity' => $request->capacity,
            ];

            $apiResponse = Http::withHeaders($headers)->put($apiurl, $data);

            if ($apiResponse->successful()) {
                return redirect()->route('gudang.index')->with('success', 'Data Gudang berhasil diperbarui!');
            } else {
                return back()->withErrors('Gagal memperbarui data Gudang: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/masterdata/warehouse/1.0.0/warehouse/' . $id;

            $apiResponse = Http::withHeaders($headers)->delete($apiurl);

            if ($apiResponse->successful()) {
                return redirect()->route('gudang.index')
                    ->with('success', 'Data Gudang berhasil dihapus');
            } else {
                return back()->withErrors(
                    'Gagal menghapus data: ' . $apiResponse->body()
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
