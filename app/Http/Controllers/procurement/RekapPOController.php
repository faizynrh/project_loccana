<?php

namespace App\Http\Controllers\procurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

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

            $requestbody = [
                'search' => $search,
                'partner_id' => $partner_id,
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
}
