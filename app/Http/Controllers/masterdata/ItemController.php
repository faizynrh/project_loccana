<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
{
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
        dump($request->all());
        Log::info($request->all());
        $length = $request->input('length'); // Default 10 item per page
        $start = $request->input('start'); // Offset data
        $search = $request->input('search'); // Query pencarian
        dump($length, $start, $search);
        try {
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/master/items/1.0.0/items/lists';
            $accessToken = $this->getAccessToken();
            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post($apiurl, [
                'search' => '', // Kirimkan parameter pencarian ke API
                'limit' => 10,
                'offset' => 0,
                'company_id' => 2,
            ]);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                // dd($data);
                return view('masterdata.items.items', ['data' => $data]);
            } else {
                return response()->json([
                    'message' => 'Failed to fetch data from API',
                    'status' => $apiResponse->status(),
                    'error' => $apiResponse->json(),
                ]);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    // public function index(Request $request)
    // {
    //     $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/master/items/1.0.0/items/lists';
    //     $accessToken = $this->getAccessToken();
    //     $limit = $request->input('length', 10); // Data per halaman
    //     $offset = $request->input('start', 0);  // Offset
    //     $search = $request->input('search.value', ''); // Pencarian

    //     try {
    //         // Kirim permintaan ke API
    //         $apiResponse = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $accessToken,
    //             'Content-Type' => 'application/json',
    //         ])->post($apiurl, [
    //             'search' => $search,
    //             'limit' => $limit,
    //             'offset' => $offset,
    //             'company_id' => 2,
    //         ]);

    //         // Ambil data dari respons API
    //         $responseData = $apiResponse->json();
    //         $list = $responseData['data']['table'] ?? [];
    //         $recordsTotal = $responseData['data']['jumlah'] ?? 0;
    //         $recordsFiltered = $responseData['data']['jumlah_filter'] ?? 0;

    //         // Pastikan $list adalah array
    //         if (is_object($list)) {
    //             $list = [$list];
    //         }

    //         // Format data sesuai dengan struktur DataTables
    //         $response = [
    //             'draw' => $request->input('draw', 0),
    //             'recordsTotal' => $recordsTotal,
    //             'recordsFiltered' => $recordsFiltered,
    //             'data' => $list,
    //         ];

    //         return response()->json($response);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'draw' => $request->input('draw', 0),
    //             'recordsTotal' => 0,
    //             'recordsFiltered' => 0,
    //             'data' => [],
    //             'error' => $th->getMessage(),
    //         ]);
    //     }
    // }



    public function create()
    {
        return view('masterdata.items.add');
    }

    public function store(Request $request)
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/master/items/1.0.0/items';
            $accessToken = $this->getAccessToken();

            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'unit_of_measure_id' => $request->input('unit_of_measure_id', 0),
                'item_type_id' => $request->input('item_type_id', 0),
                'item_category_id' => $request->input('item_category_id'),
                'sku' => $request->input('sku'), //
                'company_id' => $request->input('company_id', 0),
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post($apiurl, $data);

            $responseData = $apiResponse->json();
            // dd([
            //     'sent_data' => $data,
            //     'api_response_status' => $apiResponse->status(),
            //     'api_response_body' => $responseData,
            // ]);
            if (
                $apiResponse->successful() &&
                isset($responseData['success'])
            ) {
                return redirect()->route('items')
                    ->with('success', $responseData['message'] ?? 'Item Berhasil Ditambahkan');
            } else {
                return back()->withErrors(
                    'Gagal menambahkan data: ' .
                        ($responseData['message'] ?? $apiResponse->body())
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/master/items/1.0.0/items/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                // dd($data);
                return view('masterdata.items.detail', compact('data', 'id'));
            } else {
                return back()->withErrors('Gagal mengambil data item: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/master/items/1.0.0/items/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                return view('masterdata.items.edit', compact('data', 'id'));
            } else {
                return back()->withErrors('Gagal mengambil data item: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/master/items/1.0.0/items/' . $id;
            $accessToken = $this->getAccessToken();

            $data = [
                'name' => $request->item_name,
                'description' => $request->item_description,
                'unit_of_measure_id' => $request->uom_id,
                'item_type_id' => $request->item_type_id,
                'item_category_id' => $request->item_category_id,
                'sku' => $request->item_code,
            ];

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->put($apiurl, $data);

            if ($apiResponse->successful()) {
                // dd($data);
                return redirect()->route('items')->with('success', 'Data Item Berhasil Diubah');
            } else {
                return back()->withErrors('Gagal memperbarui data item: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $apiurl = 'https://gateway-internal.apicentrum.site/t/loccana.com/master/items/1.0.0/items/' . $id;
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->delete($apiurl);
            // dd([
            //     'status_code' => $apiResponse->status(),
            //     'headers' => $apiResponse->headers(),
            //     'body' => $apiResponse->json(),
            //     'url' => $apiurl,
            // ]);
            if ($apiResponse->successful()) {
                return redirect()->route('items')
                    ->with('success', 'Data Item Berhasil Dihapus!');
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
