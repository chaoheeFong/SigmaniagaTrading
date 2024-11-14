<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('product_name');
    $table->string('product_sku')->unique();
    $table->decimal('product_price', 8, 2);
    $table->decimal('product_cost', 8, 2);
    $table->timestamps();
});

    }

    public function transactions()
{
    return $this->belongsToMany(Transaction::class, 'product_transaction')
                ->withPivot('quantity', 'price', 'total_price')
                ->withTimestamps();
}


    public function down()
    {
        Schema::dropIfExists('products');
    }
}
