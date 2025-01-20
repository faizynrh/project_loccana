<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;


class CoaController extends Controller
{

    private function getAccessToken()
    {
        $tokenurl = env('API_TOKEN_URL');
        $clientid = env('API_CLIENT_ID');
        $clientsecret = env('API_CLIENT_SECRET');

        $tokenResponse = Http::asForm()->post($tokenurl, [
            'grant_type' => 'client_credentials',
            'client_id' => $clientid,
            'client_secret' => $clientsecret,
        ]);

        if (!$tokenResponse->successful()) {
            throw new \Exception('Failed to fetch access token');
        }

        return $tokenResponse->json()['access_token'];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $length = $request->input('length', 10);
                $start = $request->input('start', 0);
                $search = $request->input('search.value', '');


                $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/lists';
                $accessToken = $this->getAccessToken();

                $headers = [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json'
                ];

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
                    // Log::info([
                    //     'draw' => $request->input('draw'),
                    //     'recordsTotal' => $data['data']['jumlah'],
                    //     'recordsFiltered' => $data['data']['jumlah_filter'],
                    // ]);
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

        return view('masterdata.coa.coa');
    }

    public function create()
    {
        return view('masterdata.coa.add');
    }

    public function store(Request $request)
    {
        try {
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa';
            $accessToken = $this->getAccessToken();

            $data = [
                'account_name' => $request->input('account_name'),
                'account_code' => $request->input('account_code'),
                'parent_account_id' => $request->input('parent_account_id', 2),
                'account_type_id' => $request->input('account_type_id', 2),
                'description' => $request->input('description'),
                'company_id' => $request->input('company_id', 2),
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post($apiurl, $data);

            $responseData = $apiResponse->json();

            // dd([
            //     'data' => $data,
            //     'status' => $apiResponse->status(),
            //     'response' => $responseData
            // ]);
            if (
                $apiResponse->successful() &&
                isset($responseData['success'])
            ) {
                return redirect()->route('coa')
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
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);

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
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);

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
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;
            $accessToken = $this->getAccessToken();

            $data = [
                'account_name' => $request->account_name,
                'account_code' => $request->account_code,
                'parent_account_id' => $request->input('parent_account_id', 2),
                'account_type_id' => $request->input('account_type_id', 2),
                'description' => $request->description,
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->put($apiurl, $data);

            // dd([
            //     'data' => $data,
            //     'apiResponse' => $apiResponse->json(),
            // ]);

            if ($apiResponse->successful()) {
                return redirect()->route('coa')->with('success', 'Data COA berhasil diperbarui!');
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
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->delete($apiurl);
            if ($apiResponse->successful()) {
                return redirect()->route('coa')
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
