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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('productId');
            $table->string('productImage')->nullable();
            $table->string('productTitle')->default('');
            $table->string('productCategory')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('packetPrice', 8, 2)->nullable();
            $table->decimal('cartonPrice', 8, 2)->nullable();
            $table->integer('quantity')->default(0);
            $table->date('expiryDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
