<?php

namespace App\Http\Controllers\masterdata;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class UomController extends Controller
{
    //
    private function getAccessToken()
    {
        $tokenurl = env("API_TOKEN_URL");;
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

    private function getHeaders()
    {
        $accessToken = $this->getAccessToken();
        return [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ];
    }

    private function getApiUrl()
    {
        $apiurl = env('API_URL');
        return $apiurl;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $headers = $this->getHeaders();
                $apiurl = $this->getApiUrl() . '/loccana/masterdata/1.0.0/uoms/lists';

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
        return view('masterdata.uom.uom');
    }


    public function destroy($id)
    {
        try {
            $headers = $this->getHeaders();
            $apiurl = $this->getApiUrl() . '/loccana/masterdata/1.0.0/uoms/' . $id;

            $apiResponse = Http::withHeaders($headers)->delete($apiurl);
            // dd($apiResponse->json());
            if ($apiResponse->successful()) {
                return redirect()->route('uom.index')
                    ->with('success', 'Data Uom berhasil dihapus');
            } else {
                return back()->withErrors(
                    'Gagal menghapus data: ' . $apiResponse->body()
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $headers = $this->getHeaders();
            $apiurl = $this->getApiUrl() . '/loccana/masterdata/1.0.0/uoms';

            $data = [
                'name' => (string)$request->input('uom_name'),
                'symbol' => (string)$request->input('uom_symbol'),
                'description' => (string)$request->input('description',)
            ];

            $apiResponse = Http::withHeaders($headers)->post($apiurl, $data);

            $responseData = $apiResponse->json();

            // dd($data);
            if ($apiResponse->successful() && isset($responseData['success']) && $responseData['success'] === true) {
                return redirect()->route('uom.index')
                    ->with('success', $responseData['message'] ?? 'Data UoM berhasil ditambahkan.');
            } else {
                Log::error('Error saat menambahkan UoM: ' . $apiResponse->body());
                return back()->withErrors(
                    'Gagal menambahkan data: ' .
                        ($responseData['message'] ?? $apiResponse->body())
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function create()
    {
        return view('masterdata.uom.add');
    }
    public function edit($id)
    {
        try {
            $headers = $this->getHeaders();
            $apiurl = $this->getApiUrl() . '/loccana/masterdata/1.0.0/uoms/' . $id;
            // Get UoM data
            $apiResponse = Http::withHeaders($headers)->get($apiurl);
            // dd($apiResponse->json());
            if ($apiResponse->successful()) {
                $uomData = $apiResponse->json();

                if (isset($uomData['data'])) {
                    return view('masterdata.uom.edit-uom', ['uom' => $uomData['data']]);
                } else {
                    return back()->withErrors('Data UoM tidak ditemukan.');
                }
            } else {
                return back()->withErrors('Gagal mengambil data UoM dari API.');
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $headers = $this->getHeaders();
            $apiurl = $this->getApiUrl() . '/loccana/masterdata/1.0.0/uoms/' . $id;

            $data = [
                'name' => $request->input('uom_name'),
                'symbol' => $request->input('uom_symbol'),
                'description' => $request->input('description')
            ];

            $apiResponse = Http::withHeaders($headers)->put($apiurl, $data);

            if ($apiResponse->successful()) {
                return redirect()->route('uom.index')
                    ->with('success', 'Data UoM berhasil diperbarui.');
            } else {
                return back()->withErrors(
                    'Gagal memperbarui data: ' . $apiResponse->body()
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function show($id)
    {
        try {
            $headers = $this->getHeaders();
            $apiurl = $this->getApiUrl() . '/loccana/masterdata/1.0.0/uoms/' . $id;
            // Get UoM data
            $apiResponse = Http::withHeaders($headers)->get($apiurl);
            // dd($apiResponse->json());
            if ($apiResponse->successful()) {
                $uomData = $apiResponse->json();
                if (isset($uomData['data'])) {
                    return view('masterdata.uom.detail-uom', ['uom' => $uomData['data']]);
                } else {
                    return back()->withErrors('Data UoM tidak ditemukan.');
                }
            } else {
                return back()->withErrors('Gagal mengambil data UoM dari API.');
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
