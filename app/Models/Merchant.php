<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Merchant extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function customerPoints()
    {
        return $this->hasMany(CustomerPoint::class);
    }

    public function getWeeklyPointsCountAttribute()
    {
        // Get start and end date of current week (Monday-Sunday)
        $startDate = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
        $endDate = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');

        // Count the number of customer points records for this merchant in the current week
        return $this->customerPoints()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }
}
