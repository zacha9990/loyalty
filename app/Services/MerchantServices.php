<?php

namespace App\Services;

use App\Models\CustomerPoint;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class MerchantServices
{
    /**
     * Retrieve the point history for a specific merchant.
     *
     * @param int $merchantId The ID of the merchant.
     * @return Illuminate\Support\Collection
     */
    public static function getPointHistory(int $merchantId) : Collection
    {
        $customerPoints = CustomerPoint::where('merchant_id', $merchantId)
            ->where('is_referral', 0)
            ->get();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $thisWeekPoints = $customerPoints->whereBetween('created_at', [$startOfWeek, $endOfWeek]);

        return collect([
            "total_data" => $customerPoints->count(),
            "data" => $customerPoints,
            "total_data_this_week" => $thisWeekPoints->count(),
            "data_this_week" => $thisWeekPoints,
        ]);
    }
}
