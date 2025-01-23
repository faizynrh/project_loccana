<?php

namespace App\Http\Controllers\masterdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Helpers\Helpers;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $headers = Helpers::getHeaders();
                $apiurl = Helpers::getApiUrl() . '/master/items/1.0.0/items/lists';

                $length = $request->input('length', 10);
                $start = $request->input('start', 0);
                $search = $request->input('search.value', '');

                $requestbody = [
                    'limit' => $length,
                    'offset' => $start,
                    'company_id' => 2
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
        return view('masterdata.item.index');
    }

    public function create()
    {
        $headers = Helpers::getHeaders();
        $uomurl = Helpers::getApiUrl() . '/loccana/masterdata/1.0.0/uoms/list-select';
        $itemurl = Helpers::getApiUrl() . '/loccana/masterdata/item-types/1.0.0/item-types/list-select';

        $uomResponse = Http::withHeaders($headers)->get($uomurl);
        $itemResponse = Http::withHeaders($headers)->get($itemurl);

        if ($uomResponse->successful() && $itemResponse->successful()) {
            $uoms = $uomResponse->json();
            $items = $itemResponse->json();
            return view('masterdata.item.add', compact('uoms', 'items'));
        } else {
            return back()->withErrors('Gagal mengambil data dari API: UOM atau Item Types tidak tersedia.');
        }
    }

    public function store(Request $request)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/master/items/1.0.0/items';

            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'unit_of_measure_id' => $request->input('unit_of_measure_id'),
                'item_type_id' => $request->input('item_type_id'),
                'item_category_id' => $request->input('item_category_id', 1),
                'sku' => $request->input('sku'), //
                'company_id' => $request->input('company_id', 2),
            ];

            $apiResponse = Http::withHeaders($headers)->post($apiurl, $data);

            $responseData = $apiResponse->json();
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
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/master/items/1.0.0/items/' . $id;

            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                return view('masterdata.item.detail', compact('data'));
            } else {
                return back()->withErrors('Gagal mengambil data item: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/master/items/1.0.0/items/' . $id;
            $uomurl = Helpers::getApiUrl() . '/loccana/masterdata/1.0.0/uoms/list-select';
            $itemurl = Helpers::getApiUrl() . '/loccana/masterdata/item-types/1.0.0/item-types/list-select';

            $apiResponse = Http::withHeaders($headers)->get($apiurl);
            $uomResponse = Http::withHeaders($headers)->get($uomurl);
            $itemResponse = Http::withHeaders($headers)->get($itemurl);

            if ($uomResponse->successful() && $itemResponse->successful() && $apiResponse->successful()) {
                $uoms = $uomResponse->json()['data'];
                $items = $itemResponse->json()['data'];
                $data = $apiResponse->json()['data'];
                return view('masterdata.item.edit', compact('data', 'uoms', 'items', 'id'));
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
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/master/items/1.0.0/items/' . $id;

            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'unit_of_measure_id' => $request->unit_of_measure_id,
                'item_type_id' => $request->item_type_id,
                'item_category_id' => $request->input('item_category_id', 1),
                'sku' => $request->sku,
            ];

            $apiResponse = Http::withHeaders($headers)->put($apiurl, $data);

            if ($apiResponse->successful()) {
                return redirect()->route('item.index')->with('success', 'Data Item Berhasil Diubah');
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
            $headers = Helpers::getHeaders();
            $apiurl = Helpers::getApiUrl() . '/master/items/1.0.0/items/' . $id;

            $apiResponse = Http::withHeaders($headers)->delete($apiurl);

            if ($apiResponse->successful()) {
                return redirect()->route('item.index')
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
