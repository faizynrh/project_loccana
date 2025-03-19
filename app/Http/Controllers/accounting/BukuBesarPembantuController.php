<?php

namespace App\Http\Controllers\accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportAccountingBukuBesarPembantu;

class BukuBesarPembantuController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $coa_id = $request->input('coa');

            $requestbody = [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'coa_id' => $coa_id
            ];

            $apiResponse = storeApi(env('BUKU_BESAR_PEMBANTU_URL') . '/list', $requestbody);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data']['table'];
                return response()->json([
                    'data' => $data,
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
    public function index()
    {
        try {
            $company_id = 2;
            $coaResponse = fectApi(env('LIST_COA') . '/' . $company_id);
            if ($coaResponse->successful()) {
                $coa = json_decode($coaResponse->body());
                return view('accounting.bukubesarpembantu.index', compact('coa'));
            } elseif (!$coaResponse->successful()) {
                return back()->withErrors($coaResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $coa_id = $request->input('coa');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $accountname = $request->input('accountName');

            $requestbody = [
                'coa_id' => $coa_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ];
            $apiResponse = storeApi(env('BUKU_BESAR_PEMBANTU_URL') . '/list', $requestbody);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }
                $fileName = 'Laporan Buku Besar Pembantu ' . $accountname . ' ' . $start_date . ' s.d ' . $end_date . '.xlsx';
                return Excel::download(new ExportAccountingBukuBesarPembantu($data, $accountname, $start_date, $end_date), $fileName);
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
