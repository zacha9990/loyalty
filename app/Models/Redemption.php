<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'lottery_coupons',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
