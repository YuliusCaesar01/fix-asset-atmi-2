<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
      public function index()
        {
            return view("oauth.login");
        }
        public function processLogin(Request $request)
        {
            $kredensial = $request->validate([
                'email'=>'required',
                'password'=>'required'
              ]);
            if(Auth::attempt($kredensial)){
                $request->session()->regenerate(); 
                // dd(Auth::user()); 
                return redirect()->route('dashboard');
                }
                return back()->withErrors(['loginerror' => 'Login Gagal'])->withInput();  
        }
        public function logout()
        {
            Auth::logout();
            Session::flush(); // Clear all sessions for the user
             return redirect()->route('login');
        }

}
