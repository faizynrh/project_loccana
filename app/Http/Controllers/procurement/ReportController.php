<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportProcurementReport;

class ReportController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $partner_id = $request->input('principal', 0);
            $start_date = $request->input('start_date', 0);
            $end_date = $request->input('end_date', 0);
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'partner_id' => $partner_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'search' => $search,
                'company_id' => 0,
                'limit' => $length,
                'offset' => $start,
            ];

            $apiResponse = storeApi(env('REPORT_URL'), $requestbody);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json();

                $tableData = $data['data']['table'] ?? [];

                session(['export_data' => $tableData]);
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
    public function index()
    {
        try {
            $company_id = 2;
            $supplier = "true";
            $customer = "false";
            $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $company_id . '/' . $supplier . '/' . $customer);
            if ($partnerResponse->successful()) {
                $partner = json_decode($partnerResponse->body());
                return view('procurement.report.index', compact('partner'));
            } else {
                return back()->withErrors($partnerResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    public function exportExcel(Request $request)
    {
        try {
            $partner_id = $request->input('principal', 0);
            $start_date = $request->input('start_date', 0);
            $end_date = $request->input('end_date', 0);
            $principalname = $request->input('principal_name');
            $length = $request->input('total_entries');

            $requestbody = [
                'search' => '',
                'partner_id' => $partner_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'company_id' => 0,
                'limit' => $length,
                'offset' => 0,
            ];
            $apiResponse = storeApi(env('REPORT_URL'), $requestbody);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }

                return Excel::download(new ExportProcurementReport($data, $principalname, $start_date, $end_date), 'Procurement Report.xlsx');
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
