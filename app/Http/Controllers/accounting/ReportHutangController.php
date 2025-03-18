<?php

namespace App\Http\Controllers\accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportHutangController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $partner_id = $request->partner_id;
            $requestbody = [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'partner_id' => $partner_id
            ];
            $apiResponse = storeApi(env('REPORT_HUTANG_URL'), $requestbody);
            // dd($apiResponse);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                return response()->json([
                    // 'recordsTotal' => $data['data']['jumlah_filter'] ?? 0,
                    // 'recordsFiltered' => $data['data']['jumlah'] ?? 0,
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
        $customer = 'false';
        $suplier = 'true';
        $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $company_id . '/' . $suplier . '/' . $customer);

        if ($partnerResponse->successful()) {
            $partner = $partnerResponse->json()['data'];
            return view('accounting.reporthutang.index', compact('partner'));
        } else {
            $errors = [];
            if (!$partnerResponse->successful()) {
                $errors[] = $partnerResponse->json()['message'];
            }
            return back()->withErrors($errors);
        }
    }
    // public function exportExcel(Request $request)
    // {
    //     try {
    //         $start_date = $request->start_date;
    //         $end_date = $request->end_date;

    //         $requestbody = [
    //             'start_date' => $start_date,
    //             'end_date' => $end_date,
    //             'coa_id' => 0
    //         ];
    //         $apiResponse = storeApi(env('REPORT_HUTANG_URL'), $requestbody);

    //         if ($apiResponse->successful()) {
    //             $data = json_decode($apiResponse->body());
    //             if (empty($data)) {
    //                 return back()->with('error', 'Tidak ada data untuk diexport.');
    //             }
    //             $fileName = 'Laporan Laba Rugi ' . $start_date . ' s.d ' . $end_date . '.xlsx';
    //             return Excel::download(new ExportAccountingLabaRugi($data, $start_date, $end_date), $fileName);
    //         }

    //         return response()->json(['error' => $apiResponse->json()['message']]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }
}
