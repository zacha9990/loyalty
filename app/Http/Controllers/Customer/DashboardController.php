<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Point;

class DashboardController extends Controller
{
    private $guard = 'customer';

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
        $totalPoints = Auth::guard($this->guard)->user()->points;
        $expiringPoints = Point::getPointsExpiringByMonth(Auth::guard($this->guard)->user()->id);
        $nearestExpiringPoints = $expiringPoints->first();
        $totalExpiring = $expiringPoints->sum('points');

        return view('customer.dashboard.index', compact('guard', 'totalPoints', 'nearestExpiringPoints', 'totalExpiring'));
    }
}
