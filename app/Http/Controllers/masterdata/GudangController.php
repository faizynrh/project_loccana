<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


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
    public function index()
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/masterdata/warehouse/1.0.0/warehouse/list';
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
                // dd($data);
                return view('masterdata.gudang.gudang', ['data' => $data]);
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
        return view('masterdata.gudang.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/masterdata/warehouse/1.0.0/warehouse';
            $accessToken = $this->getAccessToken();

            $data = [
                'name' => $request->input('name'),
                'location' => $request->input('location'),
                'company_id' => $request->input('company_id', 0),
                'description' => $request->input('description'),
                'capacity' => $request->input('capacity', 0),
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post($apiurl, $data);

            $responseData = $apiResponse->json();
            if (
                $apiResponse->successful() &&
                isset($responseData['success'])
            ) {
                dd($request->all());

                dd([
                    'input_data' => $data,         // Data yang dikirim ke API
                    'api_response' => $responseData // Respons API
                ]);
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
        //
    }
}
