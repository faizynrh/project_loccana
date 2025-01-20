<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrincipalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            try {
                $length = $request->input('length', 10);
                $start = $request->input('start', 0);
                $search = $request->input('search.value', '');

                $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner/lists';
                $accessToken = $this->getAccessToken();

                $headers = [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json'
                ];

                $requestbody = [
                    'search' => '',
                    'limit' => $length,
                    'offset' => $start,
                    'company_id' => 2,
                    'is_customer' => false,
                    'is_supplier' => true
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
        return view('masterdata.principal.principal');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        //
        return view('masterdata.principal.tambah-principal');
    }
    public function store(Request $request)
    {
        //
        try {

            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner';
            $accessToken = $this->getAccessToken();
            // $request->validate([
            //     'uom_name' => 'required|string|max:255',
            //     'uom_code' => 'required|string|max:10',
            //     'description' => 'required|string|max:500'
            // ]);
            $data = [
                'kode' => $request->input('kode'),
                'bank1' => $request->input('bank1'),
                'norek1' => $request->input('norek1'),
                'nama' => $request->input('nama'),
                'bank2' => $request->input('bank2'),
                'norek2' => $request->input('norek2'),
                'alamat' => $request->input('alamat'),
                'bank3' => $request->input('bank3'),
                'norek3' => $request->input('norek3'),
                'notelp' => $request->input('notelp'),
                'fax' => $request->input('fax'),
                'email' => $request->input('email'),
                'status' => $request->input('status'),
            ];


            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken
            ])->post($apiurl, $data);

            $responseData = $apiResponse->json();

            // dd($data);
            if ($apiResponse->successful() && isset($responseData['success']) && $responseData['success'] === true) {
                return redirect()->route('principal.index')
                    ->with('success', $responseData['message'] ?? 'Data Principal berhasil ditambahkan.');
            } else {
                Log::error('Error saat menambahkan Principal: ' . $apiResponse->body());
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
        try {
            $apiurl = "https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner/" . $id;
            $accessToken = $this->getAccessToken();
            // Get UoM data
            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);
            dd($apiResponse->status(), $apiResponse->json());

            // dd($apiResponse->json());

            if ($apiResponse->successful()) {
                $principal = $apiResponse->json();

                if (isset($principal['data'])) {
                    return view('masterdata.principal.detail-principal', ['principal' => $principal['data']]);
                } else {
                    return back()->withErrors('Data Principal tidak ditemukan.');
                }
            } else {
                return back()->withErrors('Gagal mengambil data Principal dari API.');
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
        try {
            $apiurl = "https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner/. $id";
            $accessToken = $this->getAccessToken();
            // Get UoM data
            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);

            // dd($apiResponse->json());

            if ($apiResponse->successful()) {
                $principal = $apiResponse->json();

                if (isset($principal['data'])) {
                    return view('masterdata.principal.edit-principal', ['principal' => $principal['data']]);
                } else {
                    return back()->withErrors('Data Principal tidak ditemukan.');
                }
            } else {
                return back()->withErrors('Gagal mengambil data Principal dari API.');
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
        //
        try {
            $apiurl = "https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner/. $id";
            $accessToken = $this->getAccessToken();

            $data = [
                'kode' => $request->input('kode'),
                'bank1' => $request->input('bank1'),
                'norek1' => $request->input('norek1'),
                'nama' => $request->input('nama'),
                'bank2' => $request->input('bank2'),
                'norek2' => $request->input('norek2'),
                'alamat' => $request->input('alamat'),
                'bank3' => $request->input('bank3'),
                'norek3' => $request->input('norek3'),
                'notelp' => $request->input('notelp'),
                'fax' => $request->input('fax'),
                'email' => $request->input('email'),
                'status' => $request->input('status'),
            ];


            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->put($apiurl, $data);

            if ($apiResponse->successful()) {
                return redirect()->route('principal.index')
                    ->with('success', 'Data Principal berhasil diperbarui.');
            } else {
                return back()->withErrors(
                    'Gagal memperbarui data: ' . $apiResponse->body()
                );
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
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->delete($apiurl);
            // dd($apiResponse->json());
            if ($apiResponse->successful()) {
                return redirect()->route('principal.index')
                    ->with('success', 'Data Principal berhasil dihapus');
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
