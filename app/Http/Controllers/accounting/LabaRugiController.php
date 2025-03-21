<?php

namespace App\Http\Controllers\accounting;

use App\Exports\ExportAccountingLabaRugi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class LabaRugiController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $requestbody = [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'coa_id' => 0
            ];
            $apiResponse = storeApi(env('LABA_RUGI_URL'), $requestbody);
            // dd($apiResponse);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                return response()->json([
                    'data' => $data['data'],
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
        return view('accounting.labarugi.index');
    }
    public function exportExcel(Request $request)
    {
        try {
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $requestbody = [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'coa_id' => 0
            ];
            $apiResponse = storeApi(env('LABA_RUGI_URL'), $requestbody);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }
                $fileName = 'Laporan Laba Rugi ' . $start_date . ' s.d ' . $end_date . '.xlsx';
                return Excel::download(new ExportAccountingLabaRugi($data, $start_date, $end_date), $fileName);
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
