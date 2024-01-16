<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthConroller extends Controller
{
    function logout(){
        Auth::logout();

        return redirect('/');
    }
}
