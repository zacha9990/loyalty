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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->unique();;
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('points')->default(0);
            $table->unsignedBigInteger('referral_id')->nullable();
            $table->foreign('referral_id')->references('id')->on('customers')->onDelete('set null');
            $table->string('qr_code_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
