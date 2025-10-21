<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login() {
        // Auth::login(User::find(1));
        Auth::login(User::find(2));
        return redirect()->route('config.index');
        // return view('auth.login');
    }

    public function logout() {
        Session::flush();
        Auth::logout();
  
        return redirect()->route('root');
    }

}
