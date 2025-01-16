<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class UomDataController extends Controller
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
    protected $client;
    public function index(Request $request)
    {

        // Set API URL yang benar
        $apiurl = "https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/1.0.0/uoms/lists";

        // Ambil access token jika diperlukan untuk Authorization
        $accessToken = $this->getAccessToken();

        // Inisialisasi client Guzzle
        $this->client = new Client();

        // Dapatkan parameter limit dan offset dari request
        $limit = $request->input('length');
        $offset = $request->input('start');

        if ($offset === null) {
            $offset = 0;
        }

        // Ambil nilai pencarian jika ada
        $search = $request->input('search.value');
        if ($search !== null) {
            $search = $request->input('search.value');
        } else {
            $search = '';
        }

        // Persiapkan parameter untuk API
        $sendParams = [
            "search" =>  $search,
            "limit" => $limit,
            "offset" => $offset
        ];

        // dd($sendParams);
        try {
            // Lakukan permintaan POST menggunakan Guzzle
            $getList = $this->client->request('POST', $apiurl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken // Gunakan token yang diambil
                ],
                'json' => $sendParams
            ]);

            // Decode hasil JSON dari response
            $getList = json_decode($getList->getBody()->getContents());
            $lists = $getList->data->table;

            if (is_object($lists)) {
                $lists = [$lists];
            }

            // Ambil total data untuk keperluan DataTables
            $data['recordsTotal'] = $getList->data->jumlah_filter;
            $data['recordsFiltered'] = $getList->data->jumlah;

            // Kembalikan data ke DataTables
            return DataTables::of($lists)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    $action = "<a onclick='info($model->id)' class='btn btn-sm btn-icon btn-info btn-hover-rise me-1'>
                            <i class='bi bi-info-square'></i></a>";
                    $action .= "<a onclick='edit($model->id)' class='btn btn-sm btn-icon btn-warning btn-hover-rise me-1'>
                            <i class='bi bi-pencil-square'></i></a>";
                    return $action;
                })
                ->addColumn('status', function ($model) {
                    if ($model->status == 0) {
                        $status = '<span class="badge py-3 px-4 fs-8 badge-success">Aktif</span>';
                    } else {
                        $status = '<span class="badge py-3 px-4 fs-8 badge-danger">Tidak Aktif</span>';
                    }

                    return $status;
                })
                ->rawColumns(['action', 'status'])
                ->with('recordsTotal', $data['recordsTotal'])
                ->with('recordsFiltered', $data['recordsFiltered'])
                ->setOffset($offset)
                ->make(true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Tangani jika terjadi error pada API request
            return response()->json(['error' => 'Gagal memanggil API: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $apiurl = "https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/1.0.0/uoms/{$id}";
            $accessToken = $this->getAccessToken();
            // Get UoM data
            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);
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
            $apiurl = "https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/1.0.0/uoms/{$id}";
            $accessToken = $this->getAccessToken();

            $data = [
                'name' => $request->input('uom_name'),
                'symbol' => $request->input('simbol'),
                'description' => $request->input('description')
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->put($apiurl, $data);

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
            $apiurl = "https://gateway.apicentrum.site/t/loccana.com/loccana/masterdata/1.0.0/uoms/{$id}";
            $accessToken = $this->getAccessToken();

            // Get UoM data
            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken
            ])->get($apiurl);

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
