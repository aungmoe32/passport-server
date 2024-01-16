<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Log\Logger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class AuthController extends Controller
{

    function register(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);


        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
        ], 200);
    }


    public function login(Request $request)
    {
        // $validator = validator(request()->all(), [
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        //     'remember' => ['required'],
        // ]);

        // $remember = request('remember');


        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'validation error',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }


        // $user = User::where('email', request('email'))->first();
        // if ($user) {
        //     if (!$user->is_active) {
        //         return response()->json([
        //             'status' => false,
        //             'message' => 'Invalid User!',
        //         ], 422);
        //     }
        // }


        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => false,
                'message' => 'Email & Password does not match with our record.',
            ], 422);
        }



        // $request->session()->regenerate();


        return redirect()->intended();
    }


    function logout()
    {
        Auth::logout();
        return redirect('/');
    }


    function revoke($tokenId)
    {
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        // Revoke an access token...
        $tokenRepository->revokeAccessToken($tokenId);

        // Revoke all of the token's refresh tokens...
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
        // Artisan::call('passport:purge');
        return redirect('/');
    }

    function user()
    {
        return request()->user();
    }
}
