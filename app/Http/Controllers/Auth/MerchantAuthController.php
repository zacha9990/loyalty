<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Merchant;

class MerchantAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.merchant.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.merchant.register');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('merchant')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('merchant/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:merchants',
            'password' => 'required|confirmed',
        ]);

        $merchant = new Merchant([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $merchant->save();

        return redirect()->route('merchant.login')->with('success', 'Registration successful');
    }

    public function logout(Request $request)
    {
        $guard ='merchant';

        Auth::guard($guard)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/merchant/login');
    }
}
