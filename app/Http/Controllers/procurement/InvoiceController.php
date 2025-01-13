<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InvoiceController extends Controller
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
    public function index()
    {
        //
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/procurement/invoice/1.0.0/invoice/lists';
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post($apiurl, [
                'status' => "semua_invoice",
                'year' => '0',
                'month' => '0',
                'search' => '',
                'company_id' => 0,
                'limit' => 0,
                'offset' => 0
            ]);


            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                // dd($data);
                return view('procurement.invoice.invoice', ['data' => $data['data']]);
            } else {
                // return response([
                //     'message' => 'Gagal mendapatkan data',
                //     'status' => $apiResponse->status(),
                //     'error' => $apiResponse->json(),
                // ]);
                return view('procurement.invoice.invoice');
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


    public function destroy(string $no_invoice)
    {
        try {
            // Menyesuaikan URL API menggunakan no_invoice
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/procurement/invoice/1.0.0/invoice/' . $no_invoice;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->delete($apiurl);

            if ($apiResponse->successful()) {
                return redirect()->route('invoice.index')
                    ->with('success', 'Data Invoice dihapus');
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
