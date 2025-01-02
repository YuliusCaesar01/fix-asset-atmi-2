<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function handleGoogleCallback(Request $request)
    {
        try {
            \Log::info('Google callback received with request: ', $request->all());
            
            // Bypass SSL verification
            $user = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false])) // Disable SSL verification
                ->user();
    
            // Mencari user berdasarkan email
            $dataUser = User::where('email', $user->getEmail())->first();
    
            // Memeriksa domain email
            $emailDomain = explode("@", $user->getEmail())[1];
    
            // Validasi domain email
            if (!in_array($emailDomain, ['gmail.com'])) {
                return redirect(route('login'))->withErrors('Email tidak terdaftar.');
            }
    
            // Validasi apakah user ada di database
            if (empty($dataUser)) {
                return redirect(route('login'))->withErrors('Email tidak terdaftar.');
            }
    
             // Login user
        auth()->login($dataUser);

        // Regenerate session
        $request->session()->regenerate();

        // Redirect to the dashboard
        return redirect()->route('dashboard');

    
        } catch (\Exception $e) {
            \Log::error('Google login error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect(route('login'))->withErrors('Terjadi kesalahan saat login dengan Google. Detail: ' . $e->getMessage());
        }
    }
}


    

