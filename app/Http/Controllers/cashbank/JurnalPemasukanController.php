<?php

namespace App\Http\Controllers\cashbank;

use App\Exports\ExportJurnalPemasukan;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class JurnalPemasukanController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'limit' => $length,
                'offset' => $start,
                'company_id' => 2
            ];
            $apiResponse = storeApi(env('JURNAL_PEMASUKAN_URL') . '/list', $requestbody);
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
        return view('cashbank.jurnalpemasukan.index');
    }

    public function create()
    {
        $companyid = 2;
        $coaResponse = fectApi(env('LIST_COA') . '/' . $companyid);
        if ($coaResponse->successful()) {
            $coa = json_decode($coaResponse->body());
            return view('cashbank.jurnalpemasukan.add', compact('coa'));
        } else {
            return back()->withErrors($coaResponse->json()['message']);
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $items = [];
            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    $items[] = [
                        'coa_id' => $item['coa_credit'],
                        'credit' => $item['credit'],
                        'description' => $item['description'],
                    ];
                }
            }

            $data = [
                'transaction_date' => $request->transaction_date,
                'coa_id' => $request->coa_debit,
                'debit' => $request->debit,
                'credit' => 0,
                'description' => $request->description,
                'reference_id' => 0,
                'reference_type' => 'jurnal masuk',
                'company_id' => 2,
                'items' => $items
            ];
            $apiResponse = storeApi(env('JURNAL_PEMASUKAN_URL'), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('jurnal_pemasukan.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $apiResponse = fectApi(env('JURNAL_PEMASUKAN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('cashbank.jurnalpemasukan.detail', compact('data'));
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
            $coaResponse = fectApi(env('LIST_COA') . '/' . $companyid);
            $apiResponse = fectApi(env('JURNAL_PEMASUKAN_URL') . '/' . $id);
            if ($apiResponse->successful() && $coaResponse->successful()) {
                $coa = json_decode($coaResponse->body());
                $data = json_decode($apiResponse->body());
                $listcoa = $coa->data;
                return view('cashbank.jurnalpemasukan.edit', compact('data', 'listcoa'));
            } else {
                $errors = [];
                if (!$coaResponse->successful()) {
                    $errors[] = $coaResponse->json()['message'];
                }
                if (!$apiResponse->successful()) {
                    $errors[] = $apiResponse->json()['message'];
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
                        'coa_id' => $item['coa_credit'],
                        'credit' => $item['credit'],
                        'description' => $item['description'],
                        'id_jurnal_child' => $item['id_jurnal_child'],
                    ];
                }
            }

            $data = [
                'transaction_date' => $request->transaction_date,
                'coa_id' => $request->coa_debit,
                'debit' => $request->debit,
                'description' => $request->description,
                'items' => $items
            ];
            $apiResponse = updateApi(env('JURNAL_PEMASUKAN_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('jurnal_pemasukan.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $apiResponse = deleteApi(env('JURNAL_PEMASUKAN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('jurnal_pemasukan.index')->with('success', $apiResponse->json()['message']);
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
            $apiResponse = fectApi(env('JURNAL_PEMASUKAN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                $totalAmount = 0;
                // foreach ($datas as $item) {
                //     $totalAmount += $item->amount;
                // }
                $pdf = Pdf::loadView('cashbank.jurnalpemasukan.print', compact('data', 'totalAmount'));
                return $pdf->stream('Kas_Masuk.pdf');
            } else {
                return back()->withErrors($apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function exportExcel(Request $request)
    {
        try {
            $month = $request->input('month', 0);
            $year = $request->input('year', now()->year);
            $total_entries = $request->input('total_entries');

            // Make sure we have a reasonable number for limit
            $limit = intval($total_entries) > 0 ? intval($total_entries) : 1000;

            $requestbody = [
                'search' => $request->input('search', ''),
                'month' => $month,
                'year' => $year,
                'limit' => $limit,
                'offset' => 0,
                'company_id' => 2,
            ];

            $apiResponse = storeApi(env('JURNAL_PEMASUKAN_URL') . '/' . 'list', $requestbody);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                $tableData = $data['data']['table'];

                if (empty($tableData)) {
                    return back()->with('error', 'Tidak ada data untuk diexport.');
                }

                return Excel::download(new ExportJurnalPemasukan($tableData, $month, $year), 'Jurnal_Pemasukan.xlsx');
            }

            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
