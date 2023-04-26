<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\Point;

class QrCodeController extends Controller
{
    public function scan(Request $request, $id)
    {
         if (Auth::guard('customer')->check()) {
            return $this->customerQrCode();
        } elseif (Auth::guard('merchant')->check()) {
            return $this->merchantAddPoints($id);
        }

        // Redirect ke halaman awal atau halaman kesalahan yang sesuai
        return redirect('/customer/login');
    }

    private function customerQrCode()
    {
        $customer = Auth::guard('customer')->user();
        $qrCodePath = env('APP_URL') . "storage/" . $customer->qr_code_image;

        $viewData = [
            'customer' => $customer,
            'qrCodePath' => $qrCodePath,
            'h2title' => 'QrCode',
            'cardTitle' => 'Tunjukkan ini ke merchant!',
            'guard' => 'customer',
        ];

        return view('customer.qrcode', $viewData);
    }

    private function merchantAddPoints($id)
    {
        $points = Point::addPoint($id, Auth::guard('merchant')->user()->id);
        $customer = Customer::find($id);

        $viewData = [
            'customer' => $customer,
            'h2title' => $customer ? 'Poin ditambahkan' : 'Customer tidak ditemukan!',
            'cardTitle' => $customer ? 'Sukses' : 'Waduh!',
            'guard' => 'merchant',
            'points' => $points,
        ];

        return view('merchant.add_points', $viewData);
    }
}
