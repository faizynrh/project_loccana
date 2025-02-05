<?php

namespace App\Http\Controllers\masterdata;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class GudangController extends Controller
{
    private function buildApiUrl($endpoint)
    {
        return env('API_URL') . '/masterdata/warehouse/1.0.0/warehouse' . $endpoint;
    }
    private function ajax(Request $request)
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
            $apiResponse = storeApi($this->buildApiUrl('/lists'), $requestbody);

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
        if ($request->ajax()) {
            return $this->ajax($request);
        }

        return view('masterdata.gudang.index');
    }

    public function create()
    {
        return view('masterdata.gudang.ajax.add');
    }
    public function store(Request $request)
    {
        try {
            $data = [
                'name' => $request->input('name'),
                'location' => $request->input('location'),
                'company_id' => $request->input('company_id', 2),
                'description' => $request->input('description'),
                'capacity' => $request->input('capacity', 0),
            ];
            $apiResponse = storeApi($this->buildApiUrl('/'), $data);
            $responseData = $apiResponse->json();
            if (
                $apiResponse->successful() &&
                isset($responseData['success'])
            ) {
                return redirect()->route('gudang.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $apiResponse = fectApi($this->buildApiUrl('/' . $id));
            if (!$apiResponse->successful()) {
                return back()->withErrors($apiResponse->json()['message'] ?? 'Failed to fetch data');
            }

            $data = json_decode($apiResponse->body(), false);
            if (!$data) {
                return back()->withErrors('No data found or invalid JSON response');
            }

            return view('masterdata.gudang.ajax.edit', compact('data'));
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $data = [
                'name' => $request->name,
                'location' => $request->location,
                'description' => $request->description,
                'capacity' => $request->capacity,
            ];

            $apiResponse = updateApi($this->buildApiUrl('/' . $id), $data);

            if ($apiResponse->successful()) {
                return redirect()->route('gudang.index')->with('success', $apiResponse->json()['message']);
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
            $apiResponse = deleteApi($this->buildApiUrl('/' . $id));

            if ($apiResponse->successful()) {
                return redirect()->route('gudang.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->body());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
