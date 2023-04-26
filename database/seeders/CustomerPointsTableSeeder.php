<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CustomerPoint;
use App\Models\Merchant;
use App\Models\Redemption;
use Faker\Factory;
use QrCode;
use Illuminate\Support\Str;


class CustomerPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        CustomerPoint::factory()
            ->count(200)
            ->create();

        // sample merchant
        Merchant::create([
            'name' => "Test Merchant",
            'logo' => $faker->imageUrl(),
            'phone' => $faker->phoneNumber,
            'password' => bcrypt('merchant'),
            'email' => "merchant@gmail.com",
            'created_at' => $faker->dateTimeThisYear(),
            'updated_at' => $faker->dateTimeThisYear(),
        ]);

        //semple Customer
        $cust = Customer::create([
            'name'          => "Zacharias Hendrik",
            'phone'         => "81215663989",
            'email'         => $faker->unique()->safeEmail,
            'password'      => bcrypt("123456"),
            'points'        => $faker->numberBetween(0, 1000),
            'referral_id'   => Customer::inRandomOrder()->first()?->id,
            'qr_code_image' => $faker->imageUrl(),
            'created_at'    => $faker->dateTimeThisYear(),
            'updated_at'    => $faker->dateTimeThisYear(),
        ]);

        $appUrl = ENV('APP_URL');

        $qrCodeUrl = $appUrl . "qrcode/$cust->id";

        QrCode::format('png')->generate($qrCodeUrl, "storage/app/public/qrcodes/$cust->id.png");

        $cust->qr_code_image = "qrcodes/$cust->id.png";

        for ($i=0; $i < 50; $i++) {
            CustomerPoint::create([
                'customer_id' => $cust->id,
                'merchant_id' => Merchant::inRandomOrder()->first()->id,
                'points'      => $faker->randomElement([10, 20]),
                'created_at'  => $faker->dateTimeThisYear(),
                'updated_at'  => $faker->dateTimeThisYear(),
            ]);
        }

        $points = CustomerPoint::whereCustomerId($cust->id)->get();
        $sumPoints = $points->sum('points');

        $cust->points = $sumPoints;

        $cust->save();

        // for ($i=0; $i < 50; $i++) {
        //     $coupon = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        //     while (Redemption::where('lottery_coupons', $coupon)->where('is_used', 0)->exists()) {
        //         // jika nilai acak sudah ada dalam database, buat ulang nilai acak
        //         $coupon = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        //     }
        //     Redemption::create([
        //         'customer_id'     => $cust->id,
        //         'lottery_coupons' => $coupon,
        //     ]);
        // }
    }
}
