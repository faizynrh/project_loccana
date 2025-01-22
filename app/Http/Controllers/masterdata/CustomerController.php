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
        //
        if ($request->ajax()) {
            try {
                $headers = $this->getHeaders();
                $apiurl = $this->getApiUrl() . '/loccana/masterdata/partner/1.0.0/partner/lists';
                $length = $request->input('length', 10);
                $start = $request->input('start', 0);
                $search = $request->input('search.value', '');

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
        $companyid = 2;
        $headers = $this->getHeaders();
        $partnerurl = $this->getApiUrl() . '/loccana/masterdata/partner-type/1.0.0/partner-types/list-select';
        $coaurl = $this->getApiUrl() . '/loccana/masterdata/coa/1.0.0/masterdata/coa/list-select/' . $companyid;

        $partnerResponse = Http::withHeaders($headers)->get($partnerurl);
        $coaResponse = Http::withHeaders($headers)->get($coaurl);

        if ($partnerResponse->successful() && $coaResponse->json()) {
            $partnerTypes = $partnerResponse->json();
            $coaTypes = $coaResponse->json();
            return view('masterdata.customer.tambah-customer', compact('partnerTypes', 'coaTypes'));
        } else {
            return back()->withErrors('Gagal mengambil data dari API: Partner Types tidak tersedia.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            $headers = $this->getHeaders();
            $apiurl = $this->getApiUrl() . '/loccana/masterdata/partner/1.0.0/partner';
            $data = [
                'name' => (string)$request->input('nama'),
                'partner_type_id' => (string)$request->input('partner_type_id'),
                'contact_info' => (string)$request->input('contact_info'),
                'chart_of_account_id' => (string)$request->input('chart_of_account_id'),
                'company_id' => 2,
                'is_customer' => true,
                'is_supplier' => false
            ];
            $apiResponse = Http::withHeaders($headers)->post($apiurl, $data);

            $responseData = $apiResponse->json();


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
            $companyid = 2;
            $headers = $this->getHeaders();
            $apiurl = $this->getApiUrl() . '/loccana/masterdata/partner/1.0.0/partner/' . $id;
            $partnerurl = $this->getApiUrl() . '/loccana/masterdata/partner-type/1.0.0/partner-types/list-select';
            $coaurl = $this->getApiUrl() . '/loccana/masterdata/coa/1.0.0/masterdata/coa/list-select/' . $companyid;

            $partnerResponse = Http::withHeaders($headers)->get($partnerurl);
            $coaResponse = Http::withHeaders($headers)->get($coaurl);
            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $customer = $apiResponse->json();

                if (isset($customer['data'])) {
                    if ($partnerResponse->successful() && $coaResponse->successful()) {
                        $partnerTypes = $partnerResponse->json();
                        $data = $apiResponse->json()['data'];
                        $coaTypes = $coaResponse->json();
                        return view('masterdata.customer.detail-customer', ['customer' => $customer['data']], compact('partnerTypes', 'data', 'coaTypes'));
                    } else {
                        return back()->withErrors('Gagal mengambil data dari API: Partner Types tidak tersedia.');
                    }
                } else {
                    return back()->withErrors('Data customer tidak ditemukan.');
                }
            } else {
                return back()->withErrors('Gagal mengambil data customer dari API.');
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
        try {
            $apiurl = $this->getApiUrl() . '/loccana/masterdata/partner/1.0.0/partner/' . $id;
            $companyid = 2;
            $headers = $this->getHeaders();
            $partnerurl = $this->getApiUrl() . '/loccana/masterdata/partner-type/1.0.0/partner-types/list-select';
            $coaurl = $this->getApiUrl() . '/loccana/masterdata/coa/1.0.0/masterdata/coa/list-select/' . $companyid;

            $partnerResponse = Http::withHeaders($headers)->get($partnerurl);
            $coaResponse = Http::withHeaders($headers)->get($coaurl);
            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $customer = $apiResponse->json();

                if (isset($customer['data'])) {
                    if ($partnerResponse->successful() && $coaResponse->successful()) {
                        $partnerTypes = $partnerResponse->json();
                        $data = $apiResponse->json()['data'];
                        $coaTypes = $coaResponse->json();
                        return view('masterdata.customer.edit-customer', ['customer' => $customer['data']], compact('partnerTypes', 'data', 'coaTypes'));
                    } else {
                        // Jika API gagal diakses, tampilkan pesan error
                        return back()->withErrors('Gagal mengambil data dari API: Partner Types tidak tersedia.');
                    }
                } else {
                    return back()->withErrors('Data customer tidak ditemukan.');
                }
            } else {
                return back()->withErrors('Gagal mengambil data customer dari API.');
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
            $apiurl = $this->getApiUrl() . '/loccana/masterdata/partner/1.0.0/partner/' . $id;
            $headers = $this->getHeaders();

            $data = [
                'name' => (string)$request->input('nama'),
                'partner_type_id' => $request->input('partner_type_id'),
                'contact_info' => $request->input('contact_info',),
                'chart_of_account_id' => $request->input('chart_of_account_id',),
                'company_id' => 2,
                'is_customer' => true,
                'is_supplier' => false
            ];

            $apiResponse = Http::withHeaders($headers)->put($apiurl, $data);

            if ($apiResponse->successful()) {
                return redirect()->route('customer.index')->with('success', 'Data Customer berhasil diperbarui!');
            } else {
                return back()->withErrors('Gagal memperbarui data Customer: ' . $apiResponse->status());
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
            $apiurl = $this->getApiUrl() . '/loccana/masterdata/partner/1.0.0/partner/' . $id;
            $headers = $this->getHeaders();
            $apiResponse = Http::withHeaders($headers)->delete($apiurl);
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
