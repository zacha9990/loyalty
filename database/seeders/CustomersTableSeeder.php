<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;
use QrCode;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

         $user = User::create([
            'name' => 'Admin loyalti',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);

        Customer::factory()
        ->count(50)
        ->create();

        $customers = Customer::all();

        $appUrl = ENV('APP_URL');

        foreach ($customers as $customer)
        {
            $cust = Customer::find($customer->id);

            $qrCodeUrl = $appUrl . "qrcode/$customer->id";

            QrCode::format('png')->generate($qrCodeUrl, "storage/app/public/qrcodes/$customer->id.png");

            $cust->qr_code_image =  env('APP_URL')."/qrcodes/$customer->id.png";     

            $cust->save();
        }

        User::factory()->count(1)->create();
    }
}
