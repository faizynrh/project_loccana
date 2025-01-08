<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ItemController extends Controller
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
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/master/items/1.0.0/items/lists';
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
            dd([
                'status_code' => $apiResponse->status(),
                'headers' => $apiResponse->headers(),
                'body' => $apiResponse->json(),
                'url' => $apiurl,
                'request_data' => [
                    'search' => '',
                    'limit' => 10,
                    'offset' => 0,
                    'company_id' => 0,
                ],
            ]);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                return view('masterdata.items.items', ['data' => $data]);
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
        return view('masterdata.items.add');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/master/items/1.0.0/items/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);

            if ($apiResponse->successful()) {
                $coa = $apiResponse->json()['data'];
                return view('masterdata.items.detail', compact('coa', 'id'));
            } else {
                return back()->withErrors('Gagal mengambil data COA: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/master/items/1.0.0/items/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->delete($apiurl);
            dd([
                'status_code' => $apiResponse->status(),
                'headers' => $apiResponse->headers(),
                'body' => $apiResponse->json(),
                'url' => $apiurl,
            ]);
            if ($apiResponse->successful()) {
                return redirect()->route('items')
                    ->with('success', 'Data Items Berhasil Dihapus!');
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
