<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReturnController extends Controller
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
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/procurement/return/1.0.0/return/lists';
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                // dd($data);
                return view('procurement.return.return', ['data' => $data]);
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/procurement/return/1.0.0/return/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);
            dd([
                'status' => $apiResponse->status(),
                'headers' => $apiResponse->headers(),
                'body' => $apiResponse->json(),
                'url' => $apiurl
            ]);
            dd($apiResponse);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                dd($data);
                return view('procurement.return.detail', compact('data', 'id'));
            } else {
                return back()->withErrors('Gagal mengambil data Retur: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/procurement/return/1.0.0/return/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->delete($apiurl);
            if ($apiResponse->successful()) {
                return redirect()->route('return')
                    ->with('success', 'Data Retur berhasil dihapus');
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
