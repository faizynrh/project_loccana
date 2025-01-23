<?php

namespace App\Http\Controllers\masterdata;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class CoaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $headers = Helpers::getHeaders();
                $apiurl = Helpers::getApiUrl() . '/loccana/masterdata/coa/1.0.0/masterdata/coa/lists';

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

        return view('masterdata.coa.index');
    }

    public function create()
    {
        return view('masterdata.coa.add');
    }

    public function store(Request $request)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/masterdata/coa/1.0.0/masterdata/coa';

            $data = [
                'account_name' => $request->input('account_name'),
                'account_code' => $request->input('account_code'),
                'parent_account_id' => $request->input('parent_account_id', 2),
                'account_type_id' => $request->input('account_type_id', 2),
                'description' => $request->input('description'),
                'company_id' => $request->input('company_id', 2),
            ];

            $apiResponse = Http::withHeaders($headers)->post($apiurl, $data);
            $responseData = $apiResponse->json();

            if (
                $apiResponse->successful() &&
                isset($responseData['success'])
            ) {
                return redirect()->route('coa.index')
                    ->with('success', $responseData['message'] ?? 'Coa Berhasil Ditambahkan');
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

    public function show($id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;

            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                return view('masterdata.coa.detail', compact('data', 'id'));
            } else {
                return back()->withErrors('Gagal mengambil data COA: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;

            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                return view('masterdata.coa.edit', compact('data', 'id'));
            } else {
                return back()->withErrors('Gagal mengambil data COA: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;

            $data = [
                'account_name' => $request->account_name,
                'account_code' => $request->account_code,
                'parent_account_id' => $request->input('parent_account_id', 2),
                'account_type_id' => $request->input('account_type_id', 2),
                'description' => $request->description,
            ];

            $apiResponse = Http::withHeaders($headers)->put($apiurl, $data);

            if ($apiResponse->successful()) {
                return redirect()->route('coa.index')->with('success', 'Data COA berhasil diperbarui!');
            } else {
                return back()->withErrors('Gagal memperbarui data COA: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;

            $apiResponse = Http::withHeaders($headers)->delete($apiurl);
            if ($apiResponse->successful()) {
                return redirect()->route('coa.index')
                    ->with('success', 'Data COA berhasil dihapus');
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
