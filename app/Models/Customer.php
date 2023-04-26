<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function referrer()
    {
        return $this->belongsTo(Customer::class, 'referral_id');
    }

    public function referrals()
    {
        return $this->hasMany(Customer::class, 'referral_id');
    }

    public function customerPoints()
    {
        return $this->hasMany(CustomerPoint::class);
    }
}
