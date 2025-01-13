<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        return view('procurement.invoice.tambah-invoice');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {

            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/procurement/invoice/1.0.0/invoice';
            $accessToken = $this->getAccessToken();
            // $request->validate([
            //     'uom_name' => 'required|string|max:255',
            //     'uom_code' => 'required|string|max:10',
            //     'description' => 'required|string|max:500'
            // ]);
            $data = [
                'nodo' => $request->input('nodo'),
                'nopurchaseorder' => $request->input('nopurchaseorder'),
                'tanggal' => $request->input('tanggal'),
                'principal' => $request->input('principal'),
                'alamat' => $request->input('alamat'),
                'att' => $request->input('att'),
                'notelp' => $request->input('notelp'),
                'fax' => $request->input('fax'),
                'ship' => $request->input('ship'),
                'email' => $request->input('email'),
                'telp' => $request->input('Telp/Fax'),
                'vat' => $request->input('vat'),
                'term' => $request->input('term'),
                'keterangan' => $request->input('keterangan'),
                'noinvoice' => $request->input('noinvoice'),
                'tglinvoice' => $request->input('tglinvoice'),
                'tgljatuhtempo' => $request->input('tgljatuhtempo'),
                'keteranganinvoice' => $request->input('keteranganinvoice'),
                'fakturpajak' => $request->input('fakturpajak')
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken
            ])->post($apiurl, $data);

            $responseData = $apiResponse->json();

            // dd($data);
            if ($apiResponse->successful() && isset($responseData['success']) && $responseData['success'] === true) {
                return redirect()->route('invoice.index')
                    ->with('success', $responseData['message'] ?? 'Data Invoice berhasil ditambahkan.');
            } else {
                Log::error('Error saat menambahkan Invoice: ' . $apiResponse->body());
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
    public function edit(string $no_invoice)
    {
        //
        try {
            $apiurl = "https://gateway-internal.apicentrum.site/t/loccana.com/procurement/invoice/1.0.0/invoice/{$no_invoice}";
            $accessToken = $this->getAccessToken();
            // Get UoM data
            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);

            // dd($apiResponse->json());

            if ($apiResponse->successful()) {
                $invoice = $apiResponse->json();

                if (isset($procurement['data'])) {
                    return view('procurement.invoice.edit-invoice', ['invoice' => $invoice['data']]);
                } else {
                    return back()->withErrors('Data invoice tidak ditemukan.');
                }
            } else {
                return back()->withErrors('Gagal mengambil data invoice dari API.');
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
