<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;


class CoaController extends Controller
{
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
            // return view('masterdata.coa.coa');
            return response()->json([
                'message' => 'Failed to fetch data from API',
                'status' => $apiResponse->status(),
                'error' => $apiResponse->json(),
            ]);
        }
    }

    public function create()
    {
        return view('masterdata.coa.add');
    }
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
                ->with('success', $responseData['message'] ?? 'Data Berhasil');
        } else {
            return back()->withErrors(
                'Gagal menambahkan data: ' .
                    ($responseData['message'] ?? $apiResponse->body())
            );
        }
    }
    public function show(string $id)
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

        // dd($apiResponse->json());

        if ($apiResponse->successful()) {
            $coa = $apiResponse->json()['data'];
            dd($coa);
            return view('masterdata.coa.detail', compact('coa', 'id'));
        } else {
            return back()->withErrors('Gagal mengambil data COA: ' . $apiResponse->status());
        }
    }

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

        // dd($apiResponse->json());

        if ($apiResponse->successful()) {
            $coa = $apiResponse->json()['data'];
            // dd($coa);
            return view('masterdata.coa.edit', compact('coa', 'id'));
        } else {
            return back()->withErrors('Gagal mengambil data COA: ' . $apiResponse->status());
        }
    }
    public function update(Request $request, string $id)
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

        $data = [
            'parent_account_id' => $request->parent_name === 'tanpaparent' ? null : $request->parent_name,
            'account_code' => $request->account_code,
            'description' => $request->keterangancoa,
            'status' => $request->showhide,
        ];

        $apiResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ])->put($apiurl, $data);

        // dd($apiResponse->json());

        if ($apiResponse->successful()) {
            return redirect()->route('coa')->with('success', 'Data COA berhasil diperbarui!');
        } else {
            return back()->withErrors('Gagal memperbarui data COA: ' . $apiResponse->status());
        }
    }
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
