<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class GudangController extends Controller
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


                $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/masterdata/warehouse/1.0.0/warehouse/lists';
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

        return view('masterdata.gudang.gudang');
    }

    public function create()
    {
        return view('masterdata.gudang.add');
    }
    public function store(Request $request)
    {
        try {
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/masterdata/warehouse/1.0.0/warehouse';
            $accessToken = $this->getAccessToken();

            $data = [
                'name' => $request->input('name'),
                'location' => $request->input('location'),
                'company_id' => $request->input('company_id', 2),
                'description' => $request->input('description'),
                'capacity' => $request->input('capacity', 0),
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post($apiurl, $data);

            $responseData = $apiResponse->json();
            // dd([
            //     'sent_data' => $data,
            //     'api_response_status' => $apiResponse->status(),
            //     'api_response_body' => $responseData,
            // ]);
            if (
                $apiResponse->successful() &&
                isset($responseData['success'])
            ) {
                // dd([
                //     'input_data' => $data,         // Data yang dikirim ke API
                //     'api_response' => $responseData // Respons API
                // ]);
                return redirect()->route('gudang')
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
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/masterdata/warehouse/1.0.0/warehouse/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                // dd($data);
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
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/masterdata/warehouse/1.0.0/warehouse/' . $id;
            $accessToken = $this->getAccessToken();

            $data = [
                'name' => $request->name,
                'location' => $request->location,
                'description' => $request->description,
                'capacity' => $request->capacity,
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
                return redirect()->route('gudang')->with('success', 'Data Gudang berhasil diperbarui!');
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
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/masterdata/warehouse/1.0.0/warehouse/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->delete($apiurl);

            // dd([
            //     'status_code' => $apiResponse->status(),
            //     'headers' => $apiResponse->headers(),
            //     'body' => $apiResponse->json(),
            //     'url' => $apiurl,
            // ]);
            if ($apiResponse->successful()) {
                return redirect()->route('gudang')
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
