<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{

    protected $fillable = [
        'date', 
        'sku', 
        'product_name', 
        'price',
        'cost', 
        'total_transaction_sales',
        'total_orders', 
        'total_fulfillment_fees'
    ];

    use HasFactory;
}
