<?php

namespace App\Http\Controllers\masterdata;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class CoaController extends Controller
{
    private function buildApiUrl($endpoint)
    {
        return env('API_URL') . '/loccana/masterdata/coa/1.0.0/masterdata/coa' . $endpoint;
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

        return view('masterdata.coa.index');
    }

    public function create()
    {
        return view('masterdata.coa.ajax.add');
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'account_name' => $request->input('account_name'),
                'account_code' => $request->input('account_code'),
                'parent_account_id' => $request->input('parent_account_id', 2),
                'account_type_id' => $request->input('account_type_id', 2),
                'description' => $request->input('description'),
                'company_id' => $request->input('company_id', 2),
            ];
            $apiResponse = storeApi($this->buildApiUrl('/'), $data);

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
            $apiResponse = fectApi($this->buildApiUrl('/' . $id));
            $data = json_decode($apiResponse->getBody()->getContents());
            return view('masterdata.coa.ajax.detail', compact('data'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $apiResponse = fectApi($this->buildApiUrl('/' . $id));
            $data = json_decode($apiResponse->getBody()->getContents());
            return view('masterdata.coa.ajax.edit', data: compact('data'));
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
                'parent_account_id' => $request->input('parent_account_id', 2),
                'account_type_id' => $request->input('account_type_id', 2),
                'description' => $request->description,
            ];

            $apiResponse = updateApi($this->buildApiUrl('/' . $id), $data);
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
            $apiResponse = deleteApi($this->buildApiUrl('/' . $id));
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
