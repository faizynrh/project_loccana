<?php

namespace App\Http\Controllers\masterdata;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Helpers\Helpers;
use Faker\Extension\Helper;

class UomController extends Controller
{
    //

    private function buildApiUrl($endpoint)
    {
        return env('API_URL') . '/loccana/masterdata/1.0.0/uoms' . $endpoint;
    }

    private function ajaxuom(Request $request)
    {
        try {
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value', '');
            $requestbody = [
                'limit' => $length,
                'offset' => $start,
                'company_id' => 2
            ];
            if (!empty($search)) {
                $requestbody['search'] = $search;
            }
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
                'error' => 'Failed to fetch data',
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->ajaxuom($request);
        }
        return view('masterdata.uom.index');
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'name' => (string) $request->input('uom_name'),
                'symbol' => (string) $request->input('uom_symbol'),
                'description' => (string) $request->input('description',)
            ];
            $apiResponse = storeApi($this->buildApiUrl('/'), $data);
            $responseData = $apiResponse->json();
            // dd($data);
            if ($apiResponse->successful()) {
                return redirect()->route('uom.index')
                    ->with('success', $responseData['message']);
            } else {
                return back()->withErrors(
                    ($responseData['message'])
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function create()
    {
        return view('masterdata.uom.ajax.add');
    }
    public function edit($id)
    {
        try {
            $apiResponse = fectApi($this->buildApiUrl('/' . $id));
            if ($apiResponse->successful()) {
                $uomData = $apiResponse->json();

                if (isset($uomData['data'])) {
                    return view('masterdata.uom.ajax.edit', ['uom' => $uomData['data']]);
                } else {
                    return back()->withErrors($apiResponse->json()['message']);
                }
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    // public function update(Request $request, $id)
    // {
    //     try {
    //         $headers = getHeaders();
    //         $apiurl = $this->buildApiUrl('/' . $id);
    //         $data = [
    //             'name' => $request->input('uom_name'),
    //             'symbol' => $request->input('uom_symbol'),
    //             'description' => $request->input('description')
    //         ];
    //         $apiResponse = Http::withHeaders($headers)->put($apiurl, $data);
    //         if ($apiResponse->successful()) {
    //             return redirect()->route('uom.index')
    //                 ->with('success', $apiResponse->json()['message']);
    //         } else {
    //             return back()->withErrors(
    //                 $apiResponse->json()['message']
    //             );
    //         }
    //     } catch (\Exception $e) {
    //         return back()->withErrors($e->getMessage());
    //     }
    // }
    public function update(Request $request, $id)
    {
        try {

            $data = [
                'name' => $request->input('uom_name'),
                'symbol' => $request->input('uom_symbol'),
                'description' => $request->input('description')
            ];
            $apiResponse = updateApi($this->buildApiUrl('/' . $id), $data);

            if ($apiResponse->successful()) {
                return redirect()->route('uom.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors(
                    $apiResponse->json()['message']
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $apiResponse = fectApi($this->buildApiUrl('/' . $id));
            if ($apiResponse->successful()) {
                $uomData = $apiResponse->json();
                if (isset($uomData['data'])) {
                    return view('masterdata.uom.ajax.detail', ['uom' => $uomData['data']]);
                } else {
                    return back()->withErrors($apiResponse->json()['message']);
                }
            } else {
                return back()->withErrors(provider: $apiResponse->json()['message']);
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
                return redirect()->route('uom.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors(
                    $apiResponse->json()['message']
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
