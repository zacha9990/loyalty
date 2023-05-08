<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Merchant;
use App\Models\CustomerPoint;
use Illuminate\Support\Facades\DB;
use Throwable;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Redemption;
use Carbon\Carbon;

class Point
{
    public static function addPoint(int $customerId, int $merchantId): int
    {
        DB::beginTransaction();

        try {
            $points = self::determinePoints($customerId);

            $customerPoint = CustomerPoint::create([
                'customer_id' => $customerId,
                'merchant_id' => $merchantId,
                'points'      => $points
            ]);

            $customer = Customer::findOrFail($customerId);
            $customer->points =  $customer->points + $customerPoint->points;
            $customer->save();

            $referralId = $customer->referral_id;
            if (!empty($referralId)) {
                // Add 20% of the points to the referral
                $referralPoints = (int) ($customerPoint->points * 0.2);
                CustomerPoint::create([
                    'customer_id' => $referralId,
                    'merchant_id' => $merchantId,
                    'points'      => $referralPoints,
                    'is_referral' => 1
                ]);
                $referral = Customer::findOrFail($referralId);
                $referral->points += $referralPoints;
                $referral->save();
            }

            DB::commit();

            return $points;
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to add customer point: ' . $e->getMessage());
            return 0;
        }
    }

    public static function determinePoints(int $customerId): int
    {
        $customerPoints = DB::table('customer_points')
            ->where('customer_id', $customerId)
            ->orderByDesc('created_at')
            ->take(3)
            ->get()
            ->pluck('points');

        $points = $customerPoints->sum();

        if ($customerPoints->count() == 3) {
            $points = $points == 30 ? 20 : 10;
        }else{
            $points = 10;
        }

        return $points;
    }

    /**
     * The function allows a customer to redeem their points for lottery coupons and updates their
     * points balance accordingly, with error handling.
     *
     * @param int customerId The ID of the customer who is redeeming their points.
     * @param int pointsToRedeem The number of points that the customer wants to redeem.
     *
     * @return array An array with a "status" key and a "message" key. The "status" key can have a
     * value of "Success" or "Error" depending on whether the points were successfully redeemed or not.
     * The "message" key provides a message indicating the status of the redemption process.
     */
    public static function redeemPoints(int $customerId, int $pointsToRedeem): array
    {
        try {
            DB::beginTransaction();
            $customer = Customer::findOrFail($customerId);

            // Get the points to redeem from the request
            $lotteryCoupons = $pointsToRedeem / 50;

            // Validate the points to redeem
            if ($pointsToRedeem % 50 != 0 || $pointsToRedeem <= 0) {
                $return = [
                    "status" => "Error",
                    "message" => "Invalid points to redeem",
                ];

                return $return;
            }

            if ($customer->points < $pointsToRedeem) {
                $return = [
                    "status" => "Error",
                    "message" => "Insufficient points",
                ];

                return $return;
            }

            // Create a redemption record
            $redemption = new Redemption([
                'customer_id' => $customerId,
                'points_redeemed' => $pointsToRedeem,
                'lottery_coupons' => $lotteryCoupons,
            ]);

            $redemption->save();

            // Update customer points
            $customer->points -= $pointsToRedeem;
            // $customer->save();

            self::usePoints($pointsToRedeem, $customerId);

            DB::commit();

            $return = [
                "status" => "Success",
                "message" => "Points redeemed successfully",
            ];

            return $return;
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Failed to redeem points: ' . $e->getMessage());

            $return = [
                "status" => "Error",
                "message" => "Failed to redeem points",
            ];

            return $return;
        }
    }

    public static function expirePoints(): void
    {
        // Get the date 6 months ago
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        // Find customer points that are older than 6 months
        $expiredPoints = CustomerPoint::where('created_at', '<', $sixMonthsAgo)->get();

        // Expire the points and save the changes
        foreach ($expiredPoints as $point) {
            $pointsExpired = $point->points;
            $point->is_expired = 1;
            $point->save();

            // Update customer points in customers table
            $customer = Customer::findOrFail($point->customer_id);
            $customer->points -= $pointsExpired;
            $customer->save();
        }
    }

    public static function calculateLotteryCoupons(int $points): int
    {
        $coupons = floor($points / 50);
        return $coupons;
    }

    public static function usePoints(int $points, int $customerId): void
    {
        // Ambil beberapa record yang masih memiliki poin yang bisa digunakan
        $records = CustomerPoint::where('is_used', 0)
            ->where('points', '<=', $points)
            ->whereCustomerId($customerId)
            ->orderBy('created_at')
            ->get();

        // Loop melalui record-record tersebut dan ubah nilai is_used
        foreach ($records as $record) {
            $recordPoints = $record->points;

            // Jika nilai record melebihi poin yang tersisa, kurangi nilai $record->points
            if ($recordPoints > $points) {
                $record->points -= $points;
                $record->save();
                break;
            }

            $record->is_used = 1;
            $record->save();

            // Kurangi poin yang digunakan dari jumlah poin input
            $points -= $recordPoints;

            // Jika poin yang digunakan sudah mencukupi input, keluar dari loop
            if ($points <= 0) {
                break;
            }
        }
    }

    public static function getPointsExpiringByMonth($customerId)
    {
        $sixMonthsLater = now()->addMonths(6);
        $points = DB::table('customer_points')
            ->select(DB::raw('SUM(points) as total_points, MONTH(created_at) as expiring_month, YEAR(created_at) as expiring_year'))
            ->where('is_expired', 0)
            ->where('customer_id', $customerId)
            ->where('created_at', '<=', $sixMonthsLater)
            ->groupBy('expiring_month', 'expiring_year')
            ->orderBy('created_at')
            ->get();


        $expiringPointsByMonth = collect();
        foreach ($points as $point) {
            $expiringMonth = Carbon::createFromDate($point->expiring_year, $point->expiring_month, 1)->addMonths(6);
            $expiringPointsByMonth->push([
                'points' => $point->total_points,
                'expiring_month' => $expiringMonth->format('F Y'),
            ]);
        }

        return $expiringPointsByMonth;
    }
}
