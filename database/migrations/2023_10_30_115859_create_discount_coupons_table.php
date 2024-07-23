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
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code',155);
            $table->tinyInteger('usage_type')->comment('1=>once,2=>multiple times');
            $table->string('description',500);
            $table->decimal('min_order',10,2);
            $table->decimal('discount_amount',10,2);
            $table->tinyInteger('status')->comment('1=>active,2=>inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
    }
};
