<?php
use Illuminate\Support\Facades\Http;

function getTokenApi()
{
    $tokenurl = env('API_TOKEN_URL');
    $clientid = env('API_CLIENT_ID');
    $clientsecret = env('API_CLIENT_SECRET');

    $response = Http::asForm()->post($tokenurl, [
        'grant_type' => 'client_credentials',
        'client_id' => $clientid,
        'client_secret' => $clientsecret,
    ]);

    if (!$response->successful()) {
        throw new \Exception('Failed to fetch access token');
    }
    $data = json_decode($response->getBody()->getContents());
    return $data;
}

function fectApi($apiUrl)
{
    $access_token = getTokenApi();
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

function storeApi($apiUrl, $payloads)
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

function updateApi($apiUrl, $payloads)
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

function deleteApi($apiUrl)
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

