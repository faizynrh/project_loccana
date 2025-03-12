<?php

namespace App\Http\Controllers\cashbank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JurnalPengeluaranController extends Controller
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
            $apiResponse = storeApi(env('JURNAL_PENGELUARAN_URL') . '/list', $requestbody);
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
        return view('cashbank.jurnalpengeluaran.index');
    }

    public function create()
    {
        $companyid = 2;
        $coaResponse = fectApi(env('LIST_COA') . '/' . $companyid);
        if ($coaResponse->successful()) {
            $coa = json_decode($coaResponse->body());
            return view('cashbank.jurnalpengeluaran.add', compact('coa'));
        } else {
            return back()->withErrors($coaResponse->json()['message']);
        }
    }

    public function store(Request $request)
    {
        try {
            $items = [];
            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    $items[] = [
                        'coa_id' => $item['coa_debit'],
                        'debit' => $item['debit'],
                        'description' => $item['description'],
                    ];
                }
            }

            $data = [
                'transaction_date' => $request->transaction_date,
                'coa_id' => $request->coa_kredit,
                'credit' => $request->credit,
                'description' => $request->description,
                'reference_id' => 0,
                'company_id' => 2,
                'items' => $items
            ];
            $apiResponse = storeApi(env('JURNAL_PENGELUARAN_URL'), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('jurnal_pengeluaran.index')
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
            $apiResponse = fectApi(env('JURNAL_PENGELUARAN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('cashbank.jurnalpengeluaran.detail', compact('data'));
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
            $apiResponse = fectApi(env('JURNAL_PENGELUARAN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('cashbank.jurnalpengeluaran.detail', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $apiResponse = deleteApi(env('JURNAL_PENGELUARAN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('jurnal_pengeluaran.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
