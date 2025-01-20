<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PriceController extends Controller
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


                $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/masterdata/price/1.0.0/price-manajement/list';
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

        return view('masterdata.price.price');
    }

    public function edit($id)
    {
        try {
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/masterdata/price/1.0.0/price-manajement/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);
            // dd([
            //     'status_code' => $apiResponse->status(),
            //     'headers' => $apiResponse->headers(),
            //     'body' => $apiResponse->json(),
            //     'url' => $apiurl,
            // ]);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                // dd($data);
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
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/masterdata/price/1.0.0/price-manajement/' . $id;
            $accessToken = $this->getAccessToken();

            $data = [
                'harga_atas' => $request->harga_atas ?? 0,
                'harga_bawah' => $request->harga_bawah ?? 0,
                'harga_pokok' => $request->harga_pokok ?? 0,
                'harga_beli' => $request->harga_beli ?? 0,
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->put($apiurl, $data);
            // dd([
            //     'status_code' => $apiResponse->status(),
            //     'headers' => $apiResponse->headers(),
            //     'body' => $apiResponse->json(),
            //     'url' => $apiurl,
            //     'data' => $data
            // ]);
            if ($apiResponse->successful()) {
                return redirect()->route('price')->with('success', 'Data Price berhasil diperbarui!');
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
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/masterdata/price/1.0.0/price-manajement/approve/' . $id;
            $accessToken = $this->getAccessToken();
            // dd($accessToken);
            $data = [
                'status' => 'approve',
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->put($apiurl, $data);
            // dd($data);
            if ($apiResponse->successful()) {
                return redirect()->route('price')->with('success', 'Data Berhasil Disetujui!');
            } else {
                return back()->withErrors('Gagal Approve Price: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
