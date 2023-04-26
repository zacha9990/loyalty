<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Merchant;
use Carbon\Carbon;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $h2title = "Merchant List";
        $guard = "admin";
        return view('admin.merchants.index', compact('h2title', 'guard'));
    }

    public function list(){
        $startDate = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
        $endDate = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');

        DB::statement('set @rownum=0');
        $devs = Merchant::withCount([
                        'customerPoints' => function ($query) use ($startDate, $endDate) {
                            $query->whereBetween('created_at', [$startDate, $endDate]);
                        },
                    ])
                    ->with('customerPoints')
                    ->get();

        return Datatables::of($devs)
        ->addIndexColumn()
        ->addColumn("action", function($row){
            $btn = '<a href="'.route('admin.merchant.show',$row->id).'" class="edit btn btn-info btn-sm mx-1">View</a>';
            $btn = $btn.'<a href="'.route('admin.merchant.edit',$row->id).'" class="edit btn btn-primary btn-sm mx-1">Edit</a>';
            return $btn;
        })
         ->editColumn('logo', function(Merchant $merchant) {
                    $logo = $merchant->logo;
                    return "<img src='$logo' alt='' width='275'>";
                })
        ->rawColumns(['action', 'logo'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
