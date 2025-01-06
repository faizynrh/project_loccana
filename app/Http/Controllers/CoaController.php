<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tokenurl = 'https://gateway.apicentrum.site/oauth2/token';
        $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/list';
        $clientid = 'OsqY1VGEgsgEQxLffrDs126FfVsa';
        $clientsecret = 'AnOU_SENF6BjI1MY32OXmiKQEPMa';

        $tokenResponse = Http::asForm()->post($tokenurl, [
            'grant_type' => 'client_credentials',
            'client_id' => $clientid,
            'client_secret' => $clientsecret,
        ]);

        if (!$tokenResponse->successful()) {
            return response()->json([
                'message' => 'Failed to fetch access token',
                'error' => $tokenResponse->json(),
            ], $tokenResponse->status());
        }

        $accessToken = $tokenResponse->json()['access_token'];

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
            // dd($apiResponse->json());
            return view('masterdata.coa.coa', ['data' => $data]);
        } else {
            return view('masterdata.coa.coa');
            // return response()->json([
            //     'message' => 'Failed to fetch data from API',
            //     'status' => $apiResponse->status(),
            //     'error' => $apiResponse->json(),
            // ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('masterdata.coa.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_name' => 'required',
            'account_code' => 'required',
            'description' => 'required'
        ]);

        $tokenurl = 'https://gateway.apicentrum.site/oauth2/token';
        $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa';
        $clientid = 'OsqY1VGEgsgEQxLffrDs126FfVsa';
        $clientsecret = 'AnOU_SENF6BjI1MY32OXmiKQEPMa';

        $tokenResponse = Http::asForm()->post($tokenurl, [
            'grant_type' => 'client_credentials',
            'client_id' => $clientid,
            'client_secret' => $clientsecret,
        ]);

        if (!$tokenResponse->successful()) {
            return back()->withErrors('Gagal mendapatkan token');
        }

        $accessToken = $tokenResponse->json()['access_token'];

        $data = [
            'account_name' => $request->input('account_name'),
            'account_code' => $request->input('account_code'),
            'parent_account_id' => $request->input('parent_account_id') ?? 0,
            'account_type_id' => $request->input('account_type_id') ?? 0,
            'description' => $request->input('description'),
            'company_id' => 0
        ];

        $apiResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ])->post($apiurl, $data);

        // dd([
        //     'status' => $apiResponse->status(),
        //     'body' => $apiResponse->body(),
        //     'json' => $apiResponse->json()
        // ]);
        $responseData = $apiResponse->json();
        if (
            $apiResponse->successful() &&
            isset($responseData['success'])
            // $responseData['success'] === true
        ) {

            return redirect()->route('coa')
                ->with('success', $responseData['message'] ?? 'Data COA berhasil ditambahkan');
        } else {
            return back()->withErrors(
                'Gagal menambahkan data: ' .
                    ($responseData['message'] ?? $apiResponse->body())
            );
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
    public function edit($id)
    {
        $tokenurl = 'https://gateway.apicentrum.site/oauth2/token';
        $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;
        $clientid = 'OsqY1VGEgsgEQxLffrDs126FfVsa';
        $clientsecret = 'AnOU_SENF6BjI1MY32OXmiKQEPMa';

        $tokenResponse = Http::asForm()->post($tokenurl, [
            'grant_type' => 'client_credentials',
            'client_id' => $clientid,
            'client_secret' => $clientsecret,
        ]);

        if (!$tokenResponse->successful()) {
            return back()->withErrors('Gagal mendapatkan token');
        }

        $accessToken = $tokenResponse->json()['access_token'];

        $apiResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ])->get($apiurl);

        dd($apiResponse->json());
    }



    public function update(Request $request, string $id)
    {
        $request->validate([
            'coa_code' => 'required|string',
            'description' => 'required|string',
            'parent_account' => 'required|numeric',
            'show_hide' => 'required|string',
        ]);

        $tokenurl = 'https://gateway.apicentrum.site/oauth2/token';
        $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;
        $clientid = 'OsqY1VGEgsgEQxLffrDs126FfVsa';
        $clientsecret = 'AnOU_SENF6BjI1MY32OXmiKQEPMa';

        $tokenResponse = Http::asForm()->post($tokenurl, [
            'grant_type' => 'client_credentials',
            'client_id' => $clientid,
            'client_secret' => $clientsecret,
        ]);

        if (!$tokenResponse->successful()) {
            return back()->withErrors('Gagal mendapatkan token');
        }

        $accessToken = $tokenResponse->json()['access_token'];

        $apiResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ])->put($apiurl, [
            'coa' => $request->input('coa_code'),
            'description' => $request->input('description'),
            'parent' => $request->input('parent_account'),
            'show_hide' => $request->input('show_hide'),
        ]);

        if ($apiResponse->successful()) {
            return redirect()->route('coa.index')->with('success', 'Data COA berhasil diperbarui');
        } else {
            return back()->withErrors('Gagal memperbarui data: ' . $apiResponse->body());
        }
    }



    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tokenurl = 'https://gateway.apicentrum.site/oauth2/token';
        $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/coa/1.0.0/masterdata/coa/' . $id;
        $clientid = 'OsqY1VGEgsgEQxLffrDs126FfVsa';
        $clientsecret = 'AnOU_SENF6BjI1MY32OXmiKQEPMa';

        $tokenResponse = Http::asForm()->post($tokenurl, [
            'grant_type' => 'client_credentials',
            'client_id' => $clientid,
            'client_secret' => $clientsecret,
        ]);

        if (!$tokenResponse->successful()) {
            return back()->withErrors('Gagal mendapatkan token');
        }

        $accessToken = $tokenResponse->json()['access_token'];

        $apiResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ])->delete($apiurl);
        // dd($apiResponse->json());
        if ($apiResponse->successful()) {
            return redirect()->route('coa')
                ->with('success', 'Data COA berhasil dihapus');
        } else {
            return back()->withErrors(
                'Gagal menghapus data: ' . $apiResponse->body()
            );
        }
    }
}
