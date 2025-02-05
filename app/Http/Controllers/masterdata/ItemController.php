<?php

namespace App\Http\Controllers\masterdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ItemController extends Controller
{
    private function buildApiUrl($endpoint)
    {
        return env('API_URL') . '/master/items/1.0.0/items' . $endpoint;
    }

    private function urlSelect()
    {
        return [
            'uom' => env('API_URL') . '/loccana/masterdata/1.0.0/uoms/list-select',
            'item' => env('API_URL') . '/loccana/masterdata/item-types/1.0.0/item-types/list-select'
        ];
    }

    private function ajax(Request $request)
    {
        try {
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'limit' => $length,
                'offset' => $start,
                'company_id' => 2
            ];
            $apiResponse = storeApi($this->buildApiUrl('/lists'), $requestbody);

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
        $uomResponse = fectApi($this->urlSelect()['uom']);
        $itemResponse = fectApi($this->urlSelect()['item']);

        if ($uomResponse->successful() && $itemResponse->successful()) {
            $uom = json_decode($uomResponse->body(), false);
            $item = json_decode($itemResponse->body(), false);
            return view('masterdata.item.ajax.add', compact('uom', 'item'));
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
            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'unit_of_measure_id' => $request->input('unit_of_measure_id'),
                'item_type_id' => $request->input('item_type_id'),
                'item_category_id' => $request->input('item_category_id', 1),
                'sku' => $request->input('sku'),
                'company_id' => $request->input('company_id', 2),
            ];
            $apiResponse = storeApi($this->buildApiUrl('/'), $data);

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
            $apiResponse = fectApi($this->buildApiUrl('/' . $id));
            $data = json_decode($apiResponse->getBody()->getContents());
            return view('masterdata.item.ajax.detail', compact('data'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $apiResponse = fectApi($this->buildApiUrl('/' . $id));
            $uomResponse = fectApi($this->urlSelect()['uom']);
            $itemResponse = fectApi($this->urlSelect()['item']);

            if ($uomResponse->successful() && $itemResponse->successful() && $apiResponse->successful()) {
                $uom = json_decode($uomResponse->getBody()->getContents());
                $item = json_decode($itemResponse->getBody()->getContents());
                $data = json_decode($apiResponse->getBody()->getContents());
                return view('masterdata.item.ajax.edit', compact('data', 'uom', 'item'));
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
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'unit_of_measure_id' => $request->unit_of_measure_id,
                'item_type_id' => $request->item_type_id,
                'item_category_id' => $request->input('item_category_id', 1),
                'sku' => $request->sku,
            ];

            $apiResponse = updateApi($this->buildApiUrl('/' . $id), $data);
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
            $apiResponse = deleteApi($this->buildApiUrl('/' . $id));

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
