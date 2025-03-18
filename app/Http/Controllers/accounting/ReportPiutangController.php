<?php

namespace App\Http\Controllers\accounting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInventoryReport;

class ReportPiutangController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $partner_id = $request->input('principal');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            $requestbody = [
                'partner_id' => $partner_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ];
            Log::info($requestbody);
            $apiResponse = storeApi(env('REPORT_PIUTANG_URL'), $requestbody);
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
        $company_id = 2;
        $supplier = "false";
        $customer = "true";
        $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $company_id . '/' . $supplier . '/' . $customer);
        if ($partnerResponse->successful()) {
            $partner = json_decode($partnerResponse->body());
            return view('accounting.reportpiutang.index', compact('partner'));
        }
        return view('accounting.reportpiutang.index');
    }

    public function exportExcel(Request $request)
    {
        try {
            $partner_id = $request->input('principal', 0);
            $start_date = $request->input('start_date', 0);
            $end_date = $request->input('end_date', 0);
            $principalname = $request->input('principal_name');

            $requestbody = [
                'partner_id' => $partner_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'company_id' => 0,
            ];

            $apiResponse = storeApi(env('REPORT_PERSEDIAAN_URL') . '/lists', $requestbody);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                dd($data);
                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }
                $fileName = 'Laporan Persediaan ' . $principalname . ' ' . $start_date . ' s.d ' . $end_date . '.xlsx';
                return Excel::download(new ExportInventoryReport($data, $principalname, $start_date, $end_date), $fileName);
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
