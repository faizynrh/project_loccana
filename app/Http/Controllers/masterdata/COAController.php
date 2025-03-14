<?php

namespace App\Http\Controllers\masterdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class COAController extends Controller
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
            $apiResponse = storeApi(env('COA_URL') . '/lists', $requestbody);
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
        return view('masterdata.coa.coa.index');
    }

    public function create()
    {
        $company_id = 2;
        $coaResponse = fectApi(env('LIST_COA') . '/' . $company_id);
        $coatypeResponse = fectApi(env('LIST_COATYPES'));
        if ($coaResponse->successful() && $coatypeResponse->successful()) {
            $coa = json_decode($coaResponse->body());
            $coatype = json_decode($coatypeResponse->body());
            return view('masterdata.coa.coa.ajax.add', compact('coa', 'coatype'));
        } else {
            $errors = [];
            if (!$coaResponse->successful()) {
                $errors[] = $coaResponse->json()['message'];
            }
            if (!$coatypeResponse->successful()) {
                $errors[] = $coatypeResponse->json()['message'];
            }
            return back()->withErrors($errors);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'account_name' => $request->account_name,
                'account_code' => $request->account_code,
                'parent_account_id' => $request->input('parent_account_id', 999),
                'account_type_id' => $request->account_type_id,
                'description' => $request->description,
                'company_id' => 2,
            ];
            $apiResponse = storeApi(env('COA_URL'), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('coa.index')
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
            $coaResponse = fectApi(env('LIST_COA') . '/' . $company_id);
            $apiResponse = fectApi(env('COA_URL') . '/' . $id);
            $coatypeResponse = fectApi(env('LIST_COATYPES'));
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $coa = json_decode($coaResponse->body());
                $coatype = json_decode($coatypeResponse->body());
                return view('masterdata.coa.coa.ajax.detail', compact('data', 'coa', 'coatype'));
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
            $coaResponse = fectApi(env('LIST_COA') . '/' . $company_id);
            $apiResponse = fectApi(env('COA_URL') . '/' . $id);
            $coatypeResponse = fectApi(env('LIST_COATYPES'));
            if ($apiResponse->successful() && $coaResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $coa = json_decode($coaResponse->body());
                $coatype = json_decode($coatypeResponse->body());
                return view('masterdata.coa.coa.ajax.edit', compact('data', 'coa', 'coatype'));
            } else {
                $errors = [];
                if (!$coaResponse->successful()) {
                    $errors[] = $coaResponse->json()['message'];
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

    public function update(Request $request, $id)
    {
        try {

            $data = [
                'account_name' => $request->account_name,
                'account_code' => $request->account_code,
                'parent_account_id' => $request->parent_account_id ?? 999,
                'account_type_id' => $request->account_type_id,
                'description' => $request->description,
            ];
            $apiResponse = updateApi(env('COA_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('coa.index')->with('success', $apiResponse->json()['message']);
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
            $apiResponse = deleteApi(env('COA_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('coa.index')
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
