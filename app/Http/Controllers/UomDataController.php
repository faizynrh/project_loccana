<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class UomDataController extends Controller
{
    //
    public function index()
    {
        $tokenurl = 'https://gateway.apicentrum.site/oauth2/token';
        $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/1.0.0/uoms/lists';
        $clientid = 'OsqY1VGEgsgEQxLffrDs126FfVsa';
        $clientsecret = 'AnOU_SENF6BjI1MY32OXmiKQEPMa';

        $tokenResponse = Http::asForm()->post($tokenurl, [
            'grant_type' => 'client_credentials',
            'client_id' => $clientid,
            'client_secret' => $clientsecret,
        ]);

        if (!$tokenResponse->successful()) {
            return response()->json([
                'message' => 'Gagal mendapatkan token akses',
                'error' => $tokenResponse->json(),
            ], $tokenResponse->status());
        }

        $accessToken = $tokenResponse->json()['access_token'];

        $apiResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ])->post($apiurl, []);

        if ($apiResponse->successful()) {
            $data = $apiResponse->json();
            // dd($data);

            return view('masterdata.uom.uom', ['data' => $data['data']]);
        } else {
            // return response([
            //     'message' => 'Gagal mendapatkan data',
            //     'status' => $apiResponse->status(),
            //     'error' => $apiResponse->json(),
            // ]);
            return view('masterdata.uom.uom');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'uom_name' => 'required|string|max:255',
            'uom_code' => 'required|string|max:10',
            'description' => 'required|string|max:500'
        ]);

        $tokenurl = 'https://gateway.apicentrum.site/oauth2/token';
        $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/loccana/masterdata/1.0.0/uoms';
        $clientid = 'OsqY1VGEgsgEQxLffrDs126FfVsa';
        $clientsecret = 'AnOU_SENF6BjI1MY32OXmiKQEPMa';

        $tokenResponse = Http::asForm()->post($tokenurl, [
            'grant_type' => 'client_credentials',
            'client_id' => $clientid,
            'client_secret' => $clientsecret,
        ]);

        if (!$tokenResponse->successful()) {
            return back()->withErrors('Gagal mendapatkan token.');
        }

        $tokenData = $tokenResponse->json();
        if (!isset($tokenData['access_token'])) {
            return back()->withErrors('Token tidak tersedia dalam respons.');
        }

        $accessToken = $tokenData['access_token'];

        $data = [
            'uom_name' => $request->input('uom_name'),
            'uom_code' => $request->input('uom_code'),
            'description' => $request->input('description')
        ];

        $apiResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken
        ])->post($apiurl, $data);

        $responseData = $apiResponse->json();

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
    }


    public function create()
    {
        return view('masterdata.uom.tambah-uom',);
    }
}
