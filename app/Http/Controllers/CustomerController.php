<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        $h2title = "Customer List";
        $guard = "admin";
        return view('admin.customers.index', compact('h2title', 'guard'));
    }

    public function list(){
        DB::statement('set @rownum=0');
        $devs = Customer::select([
                    DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                    'customers.id',
                    'name',
                    'phone',
                    'email',
                    'points'
                ])
                ->get();

        return Datatables::of($devs)
        ->addIndexColumn()
        ->addColumn("action", function($row){
            $btn = '<a href="'.route('admin.customer.show',$row->id).'" class="edit btn btn-info btn-sm mx-1">View</a>';
            $btn = $btn.'<a href="'.route('admin.customer.edit',$row->id).'" class="edit btn btn-primary btn-sm mx-1">Edit</a>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function show(){
        return "1";
    }
}
