<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $length = $request->input('length');
            $start = $request->input('start');
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'limit' => $length,
                'offset' => $start,
            ];
            $apiResponse = storeApi(env('ITEM_TYPE_URL') . '/lists', $requestbody);
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
        return view('masterdata.item.itemtype.index');
    }

    public function create()
    {
        return view('masterdata.item.itemtype.ajax.add');
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
            ];
            $apiResponse = storeApi(env('ITEM_TYPE_URL'), $data);

            if ($apiResponse->successful()) {
                return redirect()->route('item_type.index')
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
            $apiResponse = fectApi(env('ITEM_TYPE_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->getBody()->getContents());

                return view('masterdata.item.itemtype.ajax.detail', compact('data'));
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
            $apiResponse = fectApi(env('ITEM_TYPE_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->getBody()->getContents());
                return view('masterdata.item.itemtype.ajax.edit', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
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
            ];
            $apiResponse = updateApi(env('ITEM_TYPE_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('item_type.index')->with('success', $apiResponse->json()['message']);
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
            $apiResponse = deleteApi(env('ITEM_TYPE_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                return redirect()->route('item_type.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
