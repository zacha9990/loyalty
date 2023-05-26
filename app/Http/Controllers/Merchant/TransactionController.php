<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerPoint;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;

class TransactionController extends Controller
{
    private $guard = 'merchant';

    public function index()
    {
        $guard = $this->guard;
        $cardTitle = 'Riwayat Transaksi';
        return view('merchant.transactions.index', compact('cardTitle', 'guard'));
    }

    public function alltimeData()
    {
        $merchantId =  $merchantId = Auth::guard($this->guard)->user()->id;
        $points = CustomerPoint::getPoints($merchantId);
        return DataTables::of($points)
            ->addColumn('customer', function ($point) {
                return $point->customer->name; // Ubah nama kolom customer_id menjadi customer
            })
            ->addColumn('point_at', function ($point) {
                return Carbon::parse($point->created_at)->locale('id')->format('d F Y, H:i:s');
            })
            ->removeColumn('merchant_id', 'is_used', 'is_referral', 'is_expired')// Hapus kolom-kolom yang tidak ingin ditampilkan
            ->make(true);
    }

    public function weeklyData()
    {
        $merchantId =  $merchantId = Auth::guard($this->guard)->user()->id;
        $weeklyPoints = CustomerPoint::getWeeklyPoints($merchantId);
        return DataTables::of($weeklyPoints)
            ->addColumn('customer', function ($point) {
                return $point->customer->name; // Ubah nama kolom customer_id menjadi customer
            })
            ->addColumn('point_at', function ($point) {
                return Carbon::parse($point->created_at)->locale('id')->format('d F Y, H:i:s');
            })
            ->removeColumn('merchant_id', 'is_used', 'is_referral', 'is_expired') // Hapus kolom-kolom yang tidak ingin ditampilkan
            ->make(true);
    }
}
