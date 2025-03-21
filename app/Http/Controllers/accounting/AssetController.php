<?php

namespace App\Http\Controllers\accounting;

use App\Exports\ExportAccountingAsset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    public function ajax(Request $request)
    {
        $search = $request->input('search.value') ?? '';
        $end_date = $request->input('end_date');
        $length = $request->input('length', 10);
        $start = $request->input('start', 0);

        $requestbody = [
            'search' => '',
            'end_date' => $end_date,
            'limit' => $length,
            'offset' => $start,
        ];


        if (!empty($search)) {
            $requestbody['search'] = $search;
        }

        $apiResponse = storeApi(env('SUBASSET_URL') . '/list', $requestbody);
        // $mtdResponse = storeApi(env('PO_URL') . '/mtd', $payloadmtd);

        if ($request->ajax()) {
            try {
                if ($apiResponse->successful()) {
                    $data = $apiResponse->json();
                    // $mtd = $mtdResponse->json();
                    return response()->json([
                        // 'draw' => $request->input('draw'),
                        'recordsTotal' => $data['data']['jumlah_filter'] ?? 0,
                        'recordsFiltered' => $data['data']['jumlah'] ?? 0,
                        'data' => $data['data']['table'] ?? [],
                        // 'mtd' => $mtd['data'] ?? [],
                    ]);
                }
                return response()->json(['error' => 'Failed to fetch data'], 500);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function index()
    {
        return view('accounting.subasset.index');
    }

    public function create()
    {
        $companyid = 2;
        $coaResponse = fectApi(env('LIST_COA') . '/' . $companyid);
        if ($coaResponse->successful()) {
            $coa =
                json_decode($coaResponse->body(), false);
            return view('accounting.subasset.ajax.add', compact('coa'));
        } else {
            $errors = [];
            if (!$coaResponse->successful()) {
                $errors[] = $coaResponse->json()['message'];
            }
            return back()->withErrors($errors);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'asset_name' => $request->asset_name,
                'asset_type' => $request->asset_type,
                'acquisition_date' => $request->acquisition_date,
                'accumulated_depreciation' => $request->accumulated_depreciation,
                'acquisition_cost' => $request->acquisition_cost,
                'depreciation_rate' => $request->depreciation_rate,
                'status' => $request->status,
                'coa_id' => $request->coa_id,
                'company_id' => 2
            ];
            $apiResponse = storeApi(env('SUBASSET_URL'), $data);
            // dd($data);
            if ($apiResponse->successful()) {
                return redirect()->route('asset.index')
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

    public function show($id)
    {
        try {
            $companyid = 2;
            $coaResponse = fectApi(env('LIST_COA') . '/' . $companyid);
            $apiResponse = fectApi(env('SUBASSET_URL') . '/' . $id);
            $data = json_decode($apiResponse->getBody()->getContents());
            $coa = json_decode($coaResponse->getBody()->getContents());
            return view(
                'accounting.subasset.ajax.detail',
                compact('data', 'coa')
            );
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        $companyid = 2;
        $coaResponse = fectApi(env('LIST_COA') . '/' . $companyid);

        $apiResponse = fectApi(env('SUBASSET_URL') . '/' . $id);
        if ($coaResponse->successful()) {
            $coa =
                json_decode($coaResponse->body(), false);
            $data = json_decode($apiResponse->getBody()->getContents(), false);

            return view('accounting.subasset.ajax.edit', compact('coa', 'data'));
        } else {
            $errors = [];
            if (!$coaResponse->successful()) {
                $errors[] = $coaResponse->json()['message'];
            }
            return back()->withErrors($errors);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = [
                'accumulated_depreciation' => $request->accumulated_depreciation,
                'acquisition_cost' => $request->acquisition_cost,
                'depreciation_rate' => $request->depreciation_rate,
                'status' => $request->status,
            ];
            $apiResponse = updateApi(env('SUBASSET_URL') . '/' . $id, $data);
            // $apiResponse = updateApi($this->buildApiUrl('/' . $id), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('asset.index')
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

    public function exportExcel(Request $request)
    {
        try {
            $end_date = $request->end_date;

            $requestbody = [
                'end_date' => $end_date,
                'coa_id' => 0
            ];
            $apiResponse = storeApi(env('SUBASSET_URL') . '/list', $requestbody);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }
                $fileName = 'Laporan Sub Asset ' . $end_date . '.xlsx';
                return Excel::download(new ExportAccountingAsset($data, $end_date), $fileName);
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }
}
