<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('merchant_id');
            $table->integer('points');
            $table->tinyInteger('is_expired')->index()->default(0);
            $table->tinyInteger('is_used')->index()->default(0);
            $table->tinyInteger('is_referral')->index()->default(0);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('merchant_id')->references('id')->on('merchants');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_points');
    }
};
