<?php

namespace App\Http\Controllers\masterdata;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ItemController extends Controller
{
    private function buildApiUrl($endpoint)
    {
        return getApiUrl() . '/master/items/1.0.0/items' . $endpoint;
    }

    private function urlSelect()
    {
        return [
            'uom' => getApiUrl() . '/loccana/masterdata/1.0.0/uoms/list-select',
            'item' => getApiUrl() . '/loccana/masterdata/item-types/1.0.0/item-types/list-select'
        ];
    }

    private function ajax(Request $request)
    {
        try {
            $headers = getHeaders();
            $apiurl = $this->buildApiUrl('/lists');

            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'limit' => $length,
                'offset' => $start,
                'company_id' => 2
            ];

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
                'error' => $apiResponse->json()['message'],
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->ajax($request);
        }
        return view('masterdata.item.index');
    }

    public function create()
    {
        $headers = getHeaders();
        $uomurl = $this->urlSelect()['uom'];
        $itemurl = $this->urlSelect()['item'];

        $uomResponse = Http::withHeaders($headers)->get($uomurl);
        $itemResponse = Http::withHeaders($headers)->get($itemurl);

        if ($uomResponse->successful() && $itemResponse->successful()) {
            $uoms = $uomResponse->json();
            $items = $itemResponse->json();
            return view('masterdata.item.add', compact('uoms', 'items'));
        } else {
            $errors = [];
            if (!$uomResponse->successful()) {
                $errors[] = $uomResponse->json()['message'];
            }
            if (!$itemResponse->successful()) {
                $errors[] = $itemResponse->json()['message'];
            }
            return back()->withErrors($errors);
        }
    }

    public function store(Request $request)
    {
        try {
            $headers = getHeaders();
            $apiurl = $this->buildApiUrl('/');

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
            if ($apiResponse->successful()) {
                return redirect()->route('item.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $headers = getHeaders();
            $apiurl = $this->buildApiUrl('/' . $id);

            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                return view('masterdata.item.detail', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $headers = getHeaders();
            $apiurl = $this->buildApiUrl('/' . $id);
            $uomurl = $this->urlSelect()['uom'];
            $itemurl = $this->urlSelect()['item'];

            $apiResponse = Http::withHeaders($headers)->get($apiurl);
            $uomResponse = Http::withHeaders($headers)->get($uomurl);
            $itemResponse = Http::withHeaders($headers)->get($itemurl);

            if ($uomResponse->successful() && $itemResponse->successful() && $apiResponse->successful()) {
                $uoms = $uomResponse->json()['data'];
                $items = $itemResponse->json()['data'];
                $data = $apiResponse->json()['data'];
                return view('masterdata.item.edit', compact('data', 'uoms', 'items', 'id'));
            } else {
                $errors = [];
                if (!$uomResponse->successful()) {
                    $errors[] = $uomResponse->json()['message'];
                }
                if (!$itemResponse->successful()) {
                    $errors[] = $itemResponse->json()['message'];
                }
                if (!$apiResponse->successful()) {
                    $errors[] = $apiResponse->json()['message'];
                }
                return back()->withErrors($errors);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $headers = getHeaders();
            $apiurl = $this->buildApiUrl('/' . $id);

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
                return redirect()->route('item.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $headers = getHeaders();
            $apiurl = $this->buildApiUrl('/' . $id);

            $apiResponse = Http::withHeaders($headers)->delete($apiurl);

            if ($apiResponse->successful()) {
                return redirect()->route('item.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
