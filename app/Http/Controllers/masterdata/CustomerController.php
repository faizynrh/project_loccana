<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
                    'is_customer' => true,
                    'is_supplier' => false
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
        return view('masterdata.customer.customer');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('masterdata.customer.tambah-customer');
    }

    /**
     * Store a newly created resource in storage.
     */
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
                'kode' => (string)$request->input('kode'),
                'nonpwp' => (string)$request->input('nonpwp'),
                'name' => (string)$request->input('nama'),
                'pemiliknpwp' => (string)$request->input('pemiliknpwp'),
                'namakontak' => (string)$request->input('namakontak'),
                'alamatpemiliknpwp' => (string)$request->input('alamatpemiliknpwp'),
                'wilayah' => (string)$request->input('wilayah'),
                'distrik' => (string)$request->input('distrik'),
                'alamat' => $request->input('alamat'),
                'kota' => (string)$request->input('kota'),
                'telepon' => (string)$request->input('telepon'),
                'group' => (string)$request->input('group'),
                'email' => (string)$request->input('email'),
                'limitkredit' => (string)$request->input('limitkredit'),
            ];
            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken
            ])->post($apiurl, $data);

            $responseData = $apiResponse->json();

            // dd($data);
            if ($apiResponse->successful() && isset($responseData['success']) && $responseData['success'] === true) {
                return redirect()->route('customer.index')
                    ->with('success', $responseData['message'] ?? 'Data customer berhasil ditambahkan.');
            } else {
                Log::error('Error saat menambahkan customer: ' . $apiResponse->body());
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
    public function show($id)
    {
        //
        try {
            $apiurl = "https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner/{$id}";
            $accessToken = $this->getAccessToken();
            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($apiurl);

            // dd($apiResponse->json());

            if ($apiResponse->successful()) {
                $customer = $apiResponse->json();

                if (isset($customer['data'])) {
                    return view('masterdata.customer.detail-customer', ['customer' => $customer['data']]);
                } else {
                    return back()->withErrors('Data Customer tidak ditemukan.');
                }
            } else {
                return back()->withErrors('Gagal mengambil data Customer dari API.');
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
            $apiurl = "partner_type_id{$id}";
            $accessToken = $this->getAccessToken();
            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);

            // dd($apiResponse->json());

            if ($apiResponse->successful()) {
                $customer = $apiResponse->json();

                if (isset($customer['data'])) {
                    return view('masterdata.customer.edit-customer', ['customer' => $customer['data']]);
                } else {
                    return back()->withErrors('Data Customer tidak ditemukan.');
                }
            } else {
                return back()->withErrors('Gagal mengambil data Customer dari API.');
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
            // Validasi Input
            $request->validate([
                'kode' => 'required|string',
                'nonpwp' => 'nullable|string',
                'nama' => 'required|string',
                'pemiliknpwp' => 'nullable|string',
                'namakontak' => 'nullable|string',
                'alamatpemiliknpwp' => 'nullable|string',
                'wilayah' => 'nullable|string',
                'distrik' => 'nullable|string',
                'alamat' => 'required|string',
                'kota' => 'nullable|string',
                'telepon' => 'nullable|string',
                'group' => 'nullable|string',
                'email' => 'nullable|email',
                'limitkredit' => 'nullable|numeric',
            ]);

            $apiurl = "https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner/" . $id;
            $accessToken = $this->getAccessToken();

            $data = [
                'kode' => $request->input('kode'),
                'nonpwp' => $request->input('nonpwp'),
                'name' => $request->input('nama'),
                'pemiliknpwp' => $request->input('pemiliknpwp'),
                'namakontak' => $request->input('namakontak'),
                'alamatpemiliknpwp' => $request->input('alamatpemiliknpwp'),
                'wilayah' => $request->input('wilayah'),
                'distrik' => $request->input('distrik'),
                'alamat' => $request->input('alamat'),
                'kota' => $request->input('kota'),
                'telepon' => $request->input('telepon'),
                'group' => $request->input('group'),
                'email' => $request->input('email'),
                'limitkredit' => $request->input('limitkredit'),
            ];

            // Debugging payload jika diperlukan
            // dd($data);

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->put($apiurl, $data);

            if ($apiResponse->successful()) {
                return redirect()->route('customer.index')
                    ->with('success', 'Data customer berhasil diperbarui.');
            } else {
                // Penanganan error lebih detail
                $errorDetails = $apiResponse->json() ?: $apiResponse->body();
                return back()->withErrors([
                    'Gagal memperbarui data. Status: ' . $apiResponse->status() . '. Detail: ' . json_encode($errorDetails),
                ]);
            }
        } catch (\Exception $e) {
            return back()->withErrors('Error: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->delete($apiurl);
            // dd($apiResponse->json());
            if ($apiResponse->successful()) {
                return redirect()->route('customer.index')
                    ->with('success', 'Data customer berhasil dihapus');
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
