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

    // search di server
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $length = $request->input('length', 0);
                $start = $request->input('start', 0);
                $search = $request->input('search.value', ''); // Ambil nilai search dari DataTables

                $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/master/items/1.0.0/items/lists';
                $accessToken = $this->getAccessToken();
                $headers = [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json'
                ];

                $requestbody = [
                    'limit' => $length,
                    'offset' => $start,
                    'company_id' => 2,
                ];

                if (!empty($search)) {
                    $requestbody['search'] = $search;
                }

                $apiResponse = Http::withHeaders($headers)->post($apiurl, $requestbody);

                if ($apiResponse->successful()) {
                    $data = $apiResponse->json();
                    return response()->json([
                        'draw' => $request->input('draw'),
                        'recordsTotal' => $data['data']['total'] ?? 0,
                        'recordsFiltered' => $data['data']['total'] ?? 0,
                        'data' => $data['data']['table'] ?? [],
                    ]);
                }

                return response()->json([
                    'error' => 'Failed to fetch data'
                ], 500);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        return view('masterdata.items.items');
    }


    // search di datatable
    // public function index(Request $request)
    // {
    //     // Check if this is a DataTables AJAX request
    //     if ($request->ajax()) {
    //         try {
    //             $length = $request->input('length', 10);
    //             $start = $request->input('start', 0);

    //             $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/master/items/1.0.0/items/lists';
    //             $accessToken = $this->getAccessToken();
    //             $apiResponse = Http::withHeaders([
    //                 'Authorization' => 'Bearer ' . $accessToken,
    //                 'Content-Type' => 'application/json'
    //             ])->post($apiurl, [
    //                 'limit' => $length,
    //                 'offset' => $start,
    //                 'company_id' => 2,
    //             ]);

    //             if ($apiResponse->successful()) {
    //                 $data = $apiResponse->json();
    //                 $tableData = $data['data']['table'] ?? [];

    //                 // Jika ada search value dari DataTables, filter data di sisi client
    //                 if ($request->has('search') && !empty($request->input('search.value'))) {
    //                     $search = strtolower($request->input('search.value'));
    //                     $tableData = collect($tableData)->filter(function ($item) use ($search) {
    //                             return str_contains(strtolower($item['item_code']), $search) ||
    //                             str_contains(strtolower($item['item_name']), $search) ||
    //                             str_contains(strtolower($item['item_description']), $search) ||
    //                             str_contains(strtolower($item['uom_name']), $search) ||
    //                             str_contains(strtolower($item['partner_name']), $search);
    //                         })->values()->all();
    //                 }

    //                 return response()->json([
    //                     'draw' => $request->input('draw'),
    //                     'recordsTotal' => $data['data']['total'] ?? 0,
    //                     'recordsFiltered' => count($tableData),
    //                     'data' => $tableData,
    //                 ]);
    //             }

    //             return response()->json([
    //                 'error' => 'Failed to fetch data'
    //             ], 500);
    //         } catch (\Exception $e) {
    //             return response()->json([
    //                 'error' => $e->getMessage()
    //             ], 500);
    //         }
    //     }

    //     // For the initial page load, just return the view
    //     return view('masterdata.items.items');
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
            $apiurl = 'https://gateway.apicentrum.site/t/loccana.com/master/items/1.0.0/items/' . $id;
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
