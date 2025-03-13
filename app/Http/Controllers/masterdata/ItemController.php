<?php

namespace App\Http\Controllers\masterdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function ajax(Request $request)
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
            $apiResponse = storeApi(env('ITEM_URL') . '/lists', $requestbody);
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
        return view('masterdata.item.index');
    }

    public function create()
    {
        $uomResponse = fectApi(env('LIST_UOM'));
        $itemResponse = fectApi(env('LIST_ITEMTYPES'));

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
                'name' => $request->name,
                'description' => $request->description,
                'unit_of_measure_id' => $request->unit_of_measure_id,
                'item_type_id' => $request->item_type_id,
                'item_category_id' => 1,
                'sku' => $request->sku,
                'company_id' => 2,
            ];
            $apiResponse = storeApi(env('ITEM_URL'), $data);

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
            $apiResponse = fectApi(env('ITEM_URL') . '/' . $id);
            $data = json_decode($apiResponse->getBody()->getContents());
            return view('masterdata.item.ajax.detail', compact('data'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $apiResponse = fectApi(env('ITEM_URL') . '/' . $id);
            $uomResponse = fectApi(env('LIST_UOM'));
            $itemResponse = fectApi(env('LIST_ITEMTYPES'));

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
                'item_category_id' => 1,
                'sku' => $request->sku,
            ];
            $apiResponse = updateApi(env('ITEM_URL') . '/' . $id, $data);
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
            $apiResponse = deleteApi(env('ITEM_URL') . '/' . $id);

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
