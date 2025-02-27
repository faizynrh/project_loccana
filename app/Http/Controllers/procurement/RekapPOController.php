<?php

namespace App\Http\Controllers\procurement;

use App\Exports\ExportProcurementRekapPO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class RekapPOController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $partner_id = $request->input('principal', 0);
            $year = $request->input('year', 0);
            $month = $request->input('month', 0);
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';
            $status = $request->input('status') ?? 'all';

            $requestbody = [
                'search' => $search,
                'partner_id' => $partner_id,
                'status' => $status,
                'year' => $year,
                'month' => $month,
                'company_id' => 0,
                'limit' => $length,
                'offset' => $start,
            ];


            $apiResponse = storeApi(env('REKAP_PO_URL'), $requestbody);
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

    public function index()
    {
        $company_id = 2;
        $supplier = "true";
        $customer = "false";
        $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $company_id . '/' . $supplier . '/' . $customer);
        if ($partnerResponse->successful()) {
            $partner = json_decode($partnerResponse->body());
            return view('procurement.rekappo.index', compact('partner'));
        }
        return view('procurement.rekappo.index');
    }

    public function exportExcel(Request $request)
    {
        try {
            $partner_id = $request->input('principal');
            $year = $request->input('year');
            $month = $request->input('month');
            $principalname = $request->input('principal_name');
            $length = $request->input('total_entries');
            $status = $request->input('status');

            $requestbody = [
                'search' => '',
                'partner_id' => $partner_id,
                'status' => $status,
                'year' => $year,
                'month' => $month,
                'company_id' => 0,
                'limit' => $length,
                'offset' => 0,
            ];



            $apiResponse = storeApi(env('REKAP_PO_URL'), $requestbody);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }
                $months = [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember'
                ];
                $bulan = $months[$month] ?? 'Bulan Tidak Valid';
                $fileName = 'Laporan Rekap PO ' . $principalname . ' ' . $bulan . ' ' . $year . '.xlsx';
                return Excel::download(new ExportProcurementRekapPO($data, $principalname, $year, $bulan, $status), $fileName);
            }
            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
