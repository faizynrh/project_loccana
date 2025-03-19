<?php

namespace App\Http\Controllers\accounting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ReportCashController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            $requestbody = [
                'start_date' => $start_date,
                'end_date' => $end_date,
            ];
            $apiResponse = storeApi(env('REPORT_CASH_URL') . '/saldo_per_bank', $requestbody);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data']['table'];
                return response()->json([
                    'data' => $data,
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
        return view('accounting.reportcash.index');
    }

    public function detailCash()
    {
        //
    }
}
