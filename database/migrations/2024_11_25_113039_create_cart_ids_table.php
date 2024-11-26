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
        Schema::create('cart_ids', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cartId');
            $table->integer('total')->default(0);
            $table->integer('amountTotal')->default(0);
            $table->string('paymentStatus')->default(null);
            $table->string('paymentMethod')->default(null);
            $table->string('customerName')->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_ids');
    }
};
