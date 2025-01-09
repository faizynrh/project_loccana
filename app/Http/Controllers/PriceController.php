<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
    public function index()
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/masterdata/price/1.0.0/price-manajement/list';
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
            // dd([
            //     'status_code' => $apiResponse->status(),
            //     'headers' => $apiResponse->headers(),
            //     'body' => $apiResponse->json(),
            //     'url' => $apiurl,
            //     'request_data' => [
            //         'search' => '',
            //         'limit' => 10,
            //         'offset' => 0,
            //         'company_id' => 0,
            //     ],
            // ]);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                return view('masterdata.price.price', ['data' => $data]);
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

    public function edit($id)
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/masterdata/price/1.0.0/price-manajement/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                dd($data);
                return view('masterdata.price.edit', compact('data', 'id'));
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
                'parent_account_id' => $request->parent_name === 'tanpaparent' ? null : $request->parent_name,
                'account_code' => $request->account_code,
                'description' => $request->keterangancoa,
                'status' => $request->showhide,
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->put($apiurl, $data);

            if ($apiResponse->successful()) {
                return redirect()->route('coa')->with('success', 'Data COA berhasil diperbarui!');
            } else {
                return back()->withErrors('Gagal memperbarui data COA: ' . $apiResponse->status());
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
        //
    }
}
