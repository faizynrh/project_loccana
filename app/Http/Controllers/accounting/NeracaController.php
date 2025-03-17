<?php

namespace App\Http\Controllers\accounting;

use App\Exports\ExportAccountingNeraca;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInventoryReport;

class NeracaController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $end_date = $request->end_date;

            $requestbody = [
                'end_date' => $end_date,
            ];
            $apiResponse = storeApi(env('NERACA_URL'), $requestbody);
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
        return view('accounting.neraca.index');
    }

    public function exportExcel(Request $request)
    {
        try {
            $end_date = $request->end_date;

            $requestbody = [
                'end_date' => $end_date,
            ];
            $apiResponse = storeApi(env('NERACA_URL'), $requestbody);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }
                $fileName = 'Laporan Neraca ' . 's.d ' . $end_date . '.xlsx';
                return Excel::download(new ExportAccountingNeraca($data, $end_date), $fileName);
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
