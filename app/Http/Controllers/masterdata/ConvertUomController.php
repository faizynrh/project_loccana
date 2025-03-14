<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConvertUomController extends Controller
{
    public function ajaxconvertuom(Request $request)
    {
        try {
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value', '');
            $requestbody = [
                'limit' => $length,
                'offset' => $start,
            ];
            if (!empty($search)) {
                $requestbody['search'] = $search;
            }
            // $apiResponse = storeApi($this->buildApiUrl('/lists'), $requestbody);
            $apiResponse = storeApi(env('CONVERT_UOM_URL') . '/lists', $requestbody);
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
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        return view('masterdata.uom.convertuom.index');
    }

    public function create()
    {
        $uomResponse = fectApi(env('LIST_UOM'));

        if ($uomResponse->successful()) {
            $uom = json_decode($uomResponse->body(), false);
            return view('masterdata.uom.convertuom.ajax.add', compact('uom'));
        } else {
            $errors = [];
            if (!$uomResponse->successful()) {
                $errors[] = $uomResponse->json()['message'];
            }
            return back()->withErrors($errors);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'from_uom_id' => $request->dari,
                'to_uom_id' => $request->ke,
                'conversion_factor' => $request->conversion_factor
            ];
            $apiResponse = storeApi(env('CONVERT_UOM_URL'), $data);

            if ($apiResponse->successful()) {
                return redirect()->route('convert_uom.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }


    public function show(string $id)
    {
        try {
            $uomResponse = fectApi(env('LIST_UOM'));
            $apiResponse = fectApi(env('CONVERT_UOM_URL') . '/' . $id);
            $data = json_decode($apiResponse->getBody()->getContents());
            $uom = json_decode($uomResponse->getBody()->getContents());
            return view('masterdata.uom.convertuom.ajax.detail', compact('data', 'uom'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        try {
            $uomResponse = fectApi(env('LIST_UOM'));
            $apiResponse = fectApi(env('CONVERT_UOM_URL') . '/' . $id);
            $data = json_decode($apiResponse->getBody()->getContents());
            $uom = json_decode($uomResponse->getBody()->getContents());
            return view('masterdata.uom.convertuom.ajax.edit', compact('data', 'uom'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = [
                'from_uom_id' => $request->dari,
                'to_uom_id' => $request->ke,
                'conversion_factor' => $request->conversion_factor
            ];
            $apiResponse = updateApi(env('CONVERT_UOM_URL') . '/' . $id, $data);

            if ($apiResponse->successful()) {
                return redirect()->route('convert_uom.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
