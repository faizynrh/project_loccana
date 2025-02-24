<?php

namespace App\Http\Controllers\penjualan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ReturnPenjualanController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $year = $request->input('year', 0);
            $month = $request->input('month', 0);
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'year' => $year,
                'month' => $month,
                'company_id' => 0,
                'limit' => $length,
                'offset' => $start,
            ];
            $apiResponse = storeApi(env('RETURN_PENJUALAN_URL') . '/list', $requestbody);
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
    public function index(Request $request)
    {
        return view('penjualan.returnpenjualan.index');
    }
    public function create()
    {
        return view('penjualan.returnpenjualan.add');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        try {
            $apiResponse = fectApi(env('RETURN_PENJUALAN_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('penjualan.returnpenjualan.detail', compact('data'));
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
            $apiResponse = fectApi(env('RETURN_PENJUALAN_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('penjualan.returnpenjualan.edit', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $items = [];
            if ($request->has('sales_order_detail_id')) {
                foreach ($request->input('sales_order_detail_id') as $index => $sales_order_detail_id) {
                    $items[] = [
                        'sales_order_detail_id' => $sales_order_detail_id,
                        'quantity' => $request->input('qty_return')[$index],
                        'notes' => $request->input('notes_item')[$index],
                    ];
                }
            }
            $data = [
                'sales_invoice_id' => $request->sales_invoice_id,
                'retrun_date' => $request->return_date,
                'notes' => $request->notes,
                'items' => $items,
            ];
            $apiResponse = updateApi(env('RETURN_PENJUALAN_URL') . '/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('return_penjualan.index')->with('success', $apiResponse->json()['message']);
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
            $apiResponse = deleteApi(env('RETURN_PENJUALAN_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('return_penjualan.index')->with('success', $apiResponse->json()['message']);
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
            $apiResponse = fectApi(env('RETURN_PENJUALAN_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                return view('penjualan.returnpenjualan.approve', compact('data'));
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
            $apiResponse = updateApi(env('RETURN_PENJUALAN_URL') . '/approve/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('return_penjualan.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function reject(Request $request, $id)
    {
        try {
            $data = [
                'status' => 'Rejected'
            ];
            $apiResponse = updateApi(env('RETURN_PENJUALAN_URL') . '/approve/' . $id, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('return_penjualan.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
