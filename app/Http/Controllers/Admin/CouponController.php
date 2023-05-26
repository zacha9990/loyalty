<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\RedemptionDataTable;

class CouponController extends Controller
{
    public function index(RedemptionDataTable $dataTable)
    {
        $guard = 'admin';
        return $dataTable->render('admin.coupons.index', compact('guard'));
    }
}
