<?php

namespace App\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class COATypeController extends Controller
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
            ];
            $apiResponse = storeApi(env('COA_TYPE_URL') . '/lists', $requestbody);
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
        return view('masterdata.coa.coatype.index');
    }

    public function create()
    {
        return view('masterdata.coa.coatype.ajax.add');
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'type_name' => $request->type_name,
                'description' => $request->description,
            ];

            $apiResponse = storeApi(env('COA_TYPE_URL'), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('coa_type.index')
                    ->with(
                        'success',
                        $apiResponse->json()['message']
                    );
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
            $company_id = 2;
            $apiResponse = fectApi(env('COA_TYPE_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('masterdata.coa.coatype.ajax.detail', compact('data'));
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
            $company_id = 2;
            $apiResponse = fectApi(env('COA_TYPE_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('masterdata.coa.coatype.ajax.edit', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = [
                'type_name' => $request->type_name,
                'description' => $request->description,
            ];
            $apiResponse = updateApi(env('COA_TYPE_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('coa_type.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $apiResponse = deleteApi(env('COA_TYPE_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('coa_type.index')
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
