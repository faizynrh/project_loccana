<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Helpers
{
    public static function fectApi($apiUrl)
    {
        $access_token = session('access_token_2');
        if (!$access_token) {
            throw new \Exception('Access token is missing from session.');
        }
        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $access_token,
                'Accept' => 'application/json',
            ])
            ->get($apiUrl);
        return $response;
    }

    public static function storeApi($apiUrl, $payloads)
    {
        $access_token = session('access_token_2');
        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
            ])
            ->withBody(json_encode($payloads), 'application/json')
            ->post($apiUrl);

        return $response;
    }

    public static function updateApi($apiUrl, $payloads)
    {
        $access_token = session('access_token_2');
        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
            ])
            ->withBody(json_encode($payloads), 'application/json')
            ->put($apiUrl);

        return $response;
    }

    public static function deleteApi($apiUrl)
    {
        $access_token = session('access_token_2');
        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
            ])
            ->delete($apiUrl);

        return $response;
    }
}
