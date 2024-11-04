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
Schema::create('transactions', function (Blueprint $table) {
    $table->id();
    $table->date('date');
    $table->string('sku');
    $table->string('product_name');
    $table->decimal('price', 10, 2);
    $table->decimal('cost', 10, 2);
    $table->decimal('total_transaction_sales', 10, 2);
    $table->integer('total_orders');
    $table->decimal('total_fulfillment_fees', 10, 2);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
