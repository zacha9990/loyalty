<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
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
        return view('merchant.dashboard.index', compact('guard'));
    }
}
