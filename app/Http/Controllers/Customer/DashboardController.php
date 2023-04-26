<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth:customer');
        $this->middleware(function ($request, $next) {
            if(auth()->guard('customer')->check()) {
                return $next($request);
            }
            abort(403, 'Unauthorized action.');
        });
    }

    public function index()
    {
        $guard = "customer";
        return view('customer.dashboard.index', compact('guard'));
    }
}
