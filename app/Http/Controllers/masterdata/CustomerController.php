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

    public function index()
    {
        //
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner/lists';
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post($apiurl, [
                'search' => '',
                'limit' => 10,
                'offset' => 0,
                'company_id' => 0,
                'is_customer' => true,
                'is_supplier' => false
            ]);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                // dd($data);
                return view('masterdata.customer.customer', ['data' => $data['data']]);
            } else {
                // return response([
                //     'message' => 'Gagal mendapatkan data',
                //     'status' => $apiResponse->status(),
                //     'error' => $apiResponse->json(),
                // ]);
                return view('masterdata.customer.customer');
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
        return view('masterdata.customer.tambah-customer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner';
            $accessToken = $this->getAccessToken();
            // $request->validate([
            //     'uom_name' => 'required|string|max:255',
            //     'uom_code' => 'required|string|max:10',
            //     'description' => 'required|string|max:500'
            // ]);
            $data = [
                'kode' => $request->input('kode'),
                'nonpwp' => $request->input('nonpwp'),
                'nama' => $request->input('nama'),
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
    public function show(string $id)
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
            $apiurl = "https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner/. $id";
            $accessToken = $this->getAccessToken();
            // Get UoM data
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
        //
        try {
            $apiurl = "https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/partner/1.0.0/partner/. $id";
            $accessToken = $this->getAccessToken();

            $data = [
                'kode' => $request->input('kode'),
                'nonpwp' => $request->input('nonpwp'),
                'nama' => $request->input('nama'),
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

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->put($apiurl, $data);

            if ($apiResponse->successful()) {
                return redirect()->route('customer.index')
                    ->with('success', 'Data customer berhasil diperbarui.');
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
