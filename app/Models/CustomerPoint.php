<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CustomerPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'merchant_id',
        'points',
    ];

    public static function getWeeklyPoints($merchantId)
    {
        $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
        $endOfWeek = \Carbon\Carbon::now()->endOfWeek();

        return self::queryPoints($merchantId, $startOfWeek, $endOfWeek);
    }

    public static function getPoints($merchantId)
    {
        return self::queryPoints($merchantId);
    }

    private static function queryPoints($merchantId, $startOfWeek = null, $endOfWeek = null)
    {
        $query = self::where('merchant_id', $merchantId);

        if ($startOfWeek && $endOfWeek) {
            $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
        }

        return $query->get();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
