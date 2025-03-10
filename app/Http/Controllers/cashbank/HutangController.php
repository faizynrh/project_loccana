<?php

namespace App\Http\Controllers\cashbank;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class HutangController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $status = $request->input('status', 0);
            $month = $request->input('month', 0);
            $year = $request->input('year', 0);
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'status' => $status,
                'month' => $month,
                'year' => $year,
                'limit' => $length,
                'offset' => $start,
            ];
            $apiResponse = storeApi(env('HUTANG_URL') . '/list', $requestbody);
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

    public function ajaxpembayaran(Request $request)
    {
        try {
            $status = $request->input('status', 0);
            $month = $request->input('month', 0);
            $year = $request->input('year', 0);
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'status' => $status,
                'month' => $month,
                'year' => $year,
                'limit' => $length,
                'offset' => $start,
            ];
            $apiResponse = storeApi(env('HUTANG_URL') . '/pembayaran/list', $requestbody);
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
        return view('cashbank.hutang.index');
    }

    public function showhutang(string $id)
    {
        try {
            $apiResponse = fectApi(env('HUTANG_URL') . '/invoice/detail/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('cashbank.hutang.detail', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function pembayaran()
    {
        return view('cashbank.hutang.pembayaran.index');
    }

    public function showpembayaran(string $id)
    {
        try {
            $apiResponse = fectApi(env('HUTANG_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('cashbank.hutang.pembayaran.detail', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function create(Request $request)
    {
        $companyid = 2;
        $supplier = "true";
        $customer = "false";
        $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $companyid . '/' . $supplier . '/' . $customer);
        $coaResponse = fectApi(env('LIST_COA') . '/' . $companyid);
        if ($partnerResponse->successful() && $coaResponse->successful()) {
            $partner
                = json_decode($partnerResponse->body(), false);
            $coa =
                json_decode($coaResponse->body(), false);
            return view('cashbank.hutang.pembayaran.add', compact('partner', 'coa'));
        } else {
            $errors = [];
            if (!$coaResponse->successful()) {
                $errors[] = $coaResponse->json()['message'];
            }
            if (!$partnerResponse->successful()) {
                $errors[] = $partnerResponse->json()['message'];
            }
            return back()->withErrors($errors);
        }
    }

    public function getinvoice($id)
    {
        $apiResponse = fectApi(env('LIST_INVOICE_BAYAR') . '/' . $id);
        if ($apiResponse->successful()) {
            return response()->json($apiResponse->json()['data']);
        } else {
            return response()->json($apiResponse->json()['message']);
        }
    }

    public function store(Request $request)
    {
        try {
            $items = [];
            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    $items[] = [
                        'invoice_id' => $item['invoice'],
                        'amount_paid' => $item['amount_paid'],
                        'payment_date' => $request->payment_date,
                        'notes' => $item['notes'],
                    ];
                }
            }

            $data = [
                'payment_number' => $request->payment_number,
                'payment_date' => $request->payment_date,
                'partner_id' => $request->principal,
                'total_amount' => $request->total_amount,
                'remaining_amount' => $request->remaining_amount,
                'payment_type' => $request->payment_type,
                'coa_id' => $request->cash_account,
                'company_id' => 2,
                'warehouse_id' => 0,
                'items' => $items
            ];
            $apiResponse = storeApi(env('HUTANG_URL'), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('hutang.pembayaran.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        try {
            $companyid = 2;
            $supplier = "true";
            $customer = "false";
            $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $companyid . '/' . $supplier . '/' . $customer);
            $coaResponse = fectApi(env('LIST_COA') . '/' . $companyid);
            $apiResponse = fectApi(env('HUTANG_URL') . '/' . $id);
            $idpartner = $apiResponse->json()['data'][0]['partner_id'];
            $invoiceResponse = fectApi(env('LIST_INVOICE_BAYAR') . '/' . $idpartner);
            if ($apiResponse->successful() && $coaResponse->successful() && $partnerResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $partner = json_decode($partnerResponse->body());
                $coa = json_decode($coaResponse->body());
                $invoice = json_decode($invoiceResponse->body());
                return view('cashbank.hutang.pembayaran.edit', compact('data', 'partner', 'coa', 'invoice'));
            } else {
                $errors = [];
                if (!$coaResponse->successful()) {
                    $errors[] = $coaResponse->json()['message'];
                }
                if (!$partnerResponse->successful()) {
                    $errors[] = $partnerResponse->json()['message'];
                }
                if (!$apiResponse->successful()) {
                    $errors[] = $apiResponse->json()['message'];
                }
                if (!$invoiceResponse->successful()) {
                    $errors[] = $invoiceResponse->json()['message'];
                }
                return back()->withErrors($errors);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $items = [];
            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    $items[] = [
                        'invoice_id' => $item['invoice'],
                        'amount_paid' => $item['amount_paid'],
                        'payment_date' => $request->payment_date,
                        'notes' => $item['notes'],
                        'payment_detail_id' => $item['id_payment_detail'],
                    ];
                }
            }

            $data = [
                'payment_date' => $request->payment_date,
                'total_amount' => $request->total_amount,
                'remaining_amount' => $request->remaining_amount,
                'payment_type' => $request->payment_type,
                'coa_id' => $request->cash_account,
                'company_id' => 2,
                'warehouse_id' => 0,
                'items' => $items
            ];
            $apiResponse = updateApi(env('HUTANG_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('hutang.pembayaran.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function detail_approve(string $id)
    {
        try {
            $apiResponse = fectApi(env('HUTANG_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('cashbank.hutang.pembayaran.approve', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            $data = [
                'status' => 'Approved'
            ];
            $apiResponse = updateApi(env('HUTANG_URL') . '/approve/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('hutang.pembayaran.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $apiResponse = deleteApi(env('HUTANG_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('hutang.pembayaran.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function print($id)
    {
        try {
            $apiResponse = fectApi(env('HUTANG_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $datas = $data->data;
                $totalAmount = 0;
                foreach ($datas as $item) {
                    $totalAmount += $item->amount;
                }
                $pdf = Pdf::loadView('cashbank.hutang.pembayaran.print', compact('datas', 'totalAmount'));
                return $pdf->stream('Transfer Stok.pdf');
            } else {
                return back()->withErrors($apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
