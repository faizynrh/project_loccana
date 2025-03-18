<?php

namespace App\Http\Controllers\accounting;

use App\Exports\ExportAccountingReportPiutang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

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
        try {
            $company_id = 2;
            $supplier = "false";
            $customer = "true";
            $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $company_id . '/' . $supplier . '/' . $customer);
            if ($partnerResponse->successful()) {
                $partner = json_decode($partnerResponse->body());
                return view('accounting.reportpiutang.index', compact('partner'));
            } elseif (!$partnerResponse->successful()) {
                return back()->withErrors($partnerResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $partner_id = $request->input('principal');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $principalname = $request->input('customer_name');

            $requestbody = [
                'partner_id' => $partner_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ];
            $apiResponse = storeApi(env('REPORT_PIUTANG_URL'), $requestbody);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }
                $fileName = 'Laporan Piutang ' . $principalname . ' ' . $start_date . ' s.d ' . $end_date . '.xlsx';
                return Excel::download(new ExportAccountingReportPiutang($data, $principalname, $start_date, $end_date), $fileName);
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
