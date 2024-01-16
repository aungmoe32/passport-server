<?php

use App\Http\Controllers\AuthConroller;
use App\Http\Controllers\ProductController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/', function () {
    return redirect('/app');
});


Route::get('/logout', [AuthConroller::class, 'logout']);




Route::get('/redirect', function () {
    if (!env('API_CLIENT_ID') || !env('API_URL') || !env('API_CLIENT_SECRET')) {
        return "Please fill API fields in env file";
    }
    $query = http_build_query([
        'client_id' => env('API_CLIENT_ID'),
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect(env('API_URL') . '/oauth/authorize?' . $query);
});



Route::get('/callback', function () {
    $http = new GuzzleHttp\Client;

    $response = $http->post(env('API_URL') . '/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => env('API_CLIENT_ID'),
            'client_secret' => env('API_CLIENT_SECRET'),
            'code' => request()->code,
        ],
    ]);

    $apiResponse = json_decode((string) $response->getBody(), true);
    session(['refresh_token' => $apiResponse['refresh_token']]);
    session(['api-token' => $apiResponse['access_token']]);

    $response = $http->get(env('API_URL') . '/v1/user', [
        'headers' =>
        [
            'Authorization' => "Bearer " . session('api-token'),
        ]
    ]);
    $apiResponse = json_decode((string) $response->getBody(), true);

    $user = User::updateOrCreate([
        'email' => $apiResponse['email'],
    ], [
        'name' => $apiResponse['name'],
        'email' => $apiResponse['email'],
        'password' => random_int(10000000, 99999999),
        'token' => session('api-token'),
        'refresh_token' => session('refresh_token')
    ]);

    session()->forget('password_hash_web');
    Auth::login($user);
    



    return redirect('/app');
});
