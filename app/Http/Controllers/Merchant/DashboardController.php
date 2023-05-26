<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MerchantServices;

class DashboardController extends Controller
{
    private $guard = 'merchant';
    public function __construct()
    {
        $this->middleware('auth:merchant');
        $this->middleware(function ($request, $next) {
            if(auth()->guard('merchant')->check()) {
                return $next($request);
            }
            abort(403, 'Unauthorized action.');
        });
    }
    public function index()
    {
        $guard = "merchant";
        $merchantId = Auth::guard($this->guard)->user()->id;
        $history = MerchantServices::getPointHistory($merchantId);
        return view('merchant.dashboard.index', compact('guard', 'history'));
    }
}
