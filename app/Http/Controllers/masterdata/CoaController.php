<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;


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

    public function index()
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/list';
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post($apiurl, [
                'search' => '',
                'limit' => 10,
                'offset' => 0,
                'company_id' => 0,
            ]);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                return view('masterdata.coa.coa', ['data' => $data]);
            } else {
                return response()->json([
                    'message' => 'Failed to fetch data from API',
                    'status' => $apiResponse->status(),
                    'error' => $apiResponse->json(),
                ]);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function create()
    {
        return view('masterdata.coa.add');
    }

    public function store(Request $request)
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa';
            $accessToken = $this->getAccessToken();

            $data = [
                'account_name' => $request->input('account_name'),
                'account_code' => $request->input('account_code'),
                'parent_account_id' => $request->input('parent_account_id', 0),
                'account_type_id' => $request->input('account_type_id', 0),
                'description' => $request->input('description'),
                'company_id' => $request->input('company_id', 0),
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post($apiurl, $data);

            $responseData = $apiResponse->json();

            // dd([
            //     'data' => $data,
            //     'apiResponse' => $apiResponse,
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
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);

            if ($apiResponse->successful()) {
                $coa = $apiResponse->json()['data'];
                return view('masterdata.coa.detail', compact('coa', 'id'));
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
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);

            if ($apiResponse->successful()) {
                $coa = $apiResponse->json()['data'];
                return view('masterdata.coa.edit', compact('coa', 'id'));
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
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;
            $accessToken = $this->getAccessToken();

            $data = [
                'account_name' => $request->account_name,
                'account_code' => $request->account_code,
                'parent_account_id' => $request->parent_account_id,
                'account_type_id' => $request->account_type_id,
                'description' => $request->description,
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->put($apiurl, $data);

            // dd([
            //     'data' => $data,
            //     'apiResponse' => $apiResponse
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
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;
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
