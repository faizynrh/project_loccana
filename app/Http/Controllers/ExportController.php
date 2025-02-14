<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportProcurementReport;

class ExportController extends Controller
{
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

            $apiResponse = storeApi(env('REPORT_URL'), $requestbody);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                $tableData = $data['data']['table'] ?? [];

                if (empty($tableData)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }

                // Passing the extra data as arguments to the ExportProcurementReport class
                return Excel::download(new ExportProcurementReport($tableData, $principalname, $start_date, $end_date), 'Procurement Report.xlsx');
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
