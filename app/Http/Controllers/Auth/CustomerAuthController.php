<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerAuthController extends Controller
{
    public function showLoginForm(Request $request)
    {

        return view('auth.customer.login');
    }

    public function showRegistrationForm(Request $request)
    {
        $ref = $request->input('ref');
        return view('auth.customer.register', compact('ref'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('customer/dashboard');
        }
        return back()->withErrors([
            'phone' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'phone' => 'required|unique:customers',
            'password' => 'required|confirmed',
        ]);

        $merchant = new Customer([
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        $merchant->save();

        return redirect()->route('merchant.login')->with('success', 'Registration successful');
    }

    public function logout(Request $request)
    {
        $guard ='customer';

        Auth::guard($guard)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/customer/login');
    }
}
