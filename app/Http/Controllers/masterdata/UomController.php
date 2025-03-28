<?php

namespace App\Http\Controllers\masterdata;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Helpers\Helpers;
use Faker\Extension\Helper;

class UomController extends Controller
{
    //
    public function ajaxuom(Request $request)
    {
        try {
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
            // $apiResponse = storeApi($this->buildApiUrl('/lists'), $requestbody);
            $apiResponse = storeApi(env('UOM_URL') . '/lists', $requestbody);
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
        return view('masterdata.uom.uom.index');
    }
    public function store(Request $request)
    {
        try {
            $data = [
                'name' => (string) $request->input('uom_name'),
                'symbol' => (string) $request->input('uom_symbol'),
                'description' => (string) $request->input('description', )
            ];
            $apiResponse = storeApi(env('UOM_URL') . '/', $data);
            // dd($data);
            if ($apiResponse->successful()) {
                return redirect()->route('uom.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors(
                    ($apiResponse->json()['message'])
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function create()
    {
        return view('masterdata.uom.uom.ajax.add');
    }
    public function edit($id)
    {
        try {
            $apiResponse = fectApi(env('UOM_URL') . '/' . $id);
            $data = json_decode($apiResponse->getBody()->getContents());
            // dd($data);
            return view(
                'masterdata.uom.uom.ajax.edit',
                compact('data')
            );
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $data = [
                'name' => (string) $request->input('uom_name'),
                'symbol' => (string) $request->input('uom_symbol'),
                'description' => (string) $request->input('description', )
            ];
            $apiResponse = updateApi(env('UOM_URL') . '/' . $id, $data);
            // $apiResponse = updateApi($this->buildApiUrl('/' . $id), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('uom.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors(
                    $apiResponse->json()['message']
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function show($id)
    {
        try {
            $apiResponse = fectApi(env('UOM_URL') . '/' . $id);
            $data = json_decode($apiResponse->getBody()->getContents());
            // dd($data);
            return view(
                'masterdata.uom.uom.ajax.detail',

                compact('data')
            );
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function destroy(string $id)
    {
        try {
            $apiResponse = deleteApi(env('UOM_URL') . '/' . $id);
            // $apiResponse = deleteApi($this->buildApiUrl('/' . $id));
            if ($apiResponse->successful()) {
                return redirect()->route('uom.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors(
                    $apiResponse->json()['message']
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
