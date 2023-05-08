<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use Hash;
use QrCode;

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
        $phone = $request->input('phone');
        if (substr($phone, 0, 3) === '+62') {
            $phone = substr($phone, 3);
        } elseif (substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }
        $phone = str_replace([' ', '-'], '', $phone);
        $request->merge(['phone' => $phone]);

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
        $phone = $request->input('phone');
        if (substr($phone, 0, 3) === '+62') {
            $phone = substr($phone, 3);
        } elseif (substr($phone, 0, 1) === '0') {
            $phone = substr($phone, 1);
        }
        $phone = str_replace([' ', '-'], '', $phone);
        $request->merge(['phone' => $phone]);

        $request->validate([
            'phone' => ['required', 'string', 'max:255', Rule::unique('customers')],
            'password' => 'required|string|min:6|confirmed',
        ]);

        $customer = new Customer();
        $customer->phone = $request->phone;
        $customer->password = Hash::make($request->password);
        $customer->referral_id = $request->input('ref');

        $customer->save();

        $appUrl = ENV('APP_URL');

        $qrCodeUrl = $appUrl . "qrcode/$customer->id";

        $directory = storage_path('app\public\qrcodes');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        QrCode::format('png')->generate($qrCodeUrl, storage_path("app/public/qrcodes/$customer->id.png"));

        $customer->qr_code_image = "qrcodes/$customer->id.png";

        $customer->save();

        return redirect()->route('customer.login')->with('success', 'Sukses mendaftar, silakan login');

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
