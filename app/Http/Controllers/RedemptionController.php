<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Redemption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use App\Services\Point;
use App\Models\Customer;


class RedemptionController extends Controller
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
        $h2title = "Daftar Kupon";
        $guard = $this->guard;
        $totalPoints = Auth::guard('customer')->user()->points;
        return view('customer.redeem.convert', compact('h2title', 'guard', 'totalPoints'));
    }

    public function convertForm()
    {
        $formTitle = 'Tukar Poin';
        $guard = $this->guard;
        $totalPoints = Auth::guard($this->guard)->user()->points;
        $maxCoupons = Point::calculateLotteryCoupons($totalPoints);

        return view('customer.redeem.form', compact('formTitle', 'guard', 'totalPoints', 'maxCoupons'));
    }

    public function convertProcess(Request $request)
    {
        $customer = Customer::findOrFail(Auth::guard($this->guard)->user()->id);

        $pointsToRedeem = $request->input('poin');

        if ($pointsToRedeem <= 0 || $pointsToRedeem > $customer->points) {
            return response()->json(['message' => 'Invalid points to redeem'], 400);
        }

        $lotteryCoupons = Point::calculateLotteryCoupons($pointsToRedeem);

        Point::usePoints($pointsToRedeem, $customer->id);

        // Kurangi poin pelanggan dengan poin yang dikonversi
        $customer->points -= $pointsToRedeem;
        $customer->save();

        // Buat record redemptions
        for ($i=0; $i < $lotteryCoupons; $i++)
        {
            $coupon = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            while (Redemption::where('lottery_coupons', $coupon)->where('is_used', 0)->exists()) {
                $coupon = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            }

            Redemption::create([
                'customer_id'     => $customer->id,
                'lottery_coupons' => $coupon,
            ]);
        }

        return redirect()->route('customer.coupons');
    }

    public function list()
    {
        $customerId = Auth::guard('customer')->user()->id;

        DB::statement('set @rownum=0');
        $devs = Redemption::select([
                    DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    'lottery_coupons',
                    'created_at',
                ])
                ->whereCustomerId($customerId)
                ->whereIsUsed(0)
                ->get();

        return Datatables::of($devs)
        ->addIndexColumn()
        ->editColumn('created_at', function (Redemption $r){
            return Carbon::parse($r->created_at)->format('d M Y');
        })
        ->make(true);
    }

    public function redeemPoints(Request $request, $customerId)
    {
        // Get customer data
        $customer = Customer::findOrFail($customerId);
        $pointsToRedeem = $request->input('points_to_redeem');

        $return = Point::redeemPoints($customerId, $pointsToRedeem);

        return response()->json($return, 200);
    }
}
