<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportPenjualanDasar;

class DasarPenjualanController extends Controller
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
                'search' => $search,
                'partner_id' => $partner_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'company_id' => 0,
                'limit' => $length,
                'offset' => $start,
            ];
            $apiResponse = storeApi(env('DASAR_PENJUALAN_URL'), $requestbody);
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
            return view('penjualan.dasarpenjualan.index', compact('partner'));
        }
        return view('penjualan.dasarpenjualan.index');
    }

    public function exportExcel(Request $request)
    {
        try {
            $partner_id = $request->input('principal');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
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

            $apiResponse = storeApi(env('DASAR_PENJUALAN_URL'), $requestbody);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                if (empty($data)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }
                $fileName = 'Laporan Dasar Penjualan ' . $principalname . ' ' . $start_date . ' s.d ' .
                    $end_date . '.xlsx';
                return Excel::download(new ExportPenjualanDasar($data, $principalname, $start_date, $end_date), $fileName);
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
