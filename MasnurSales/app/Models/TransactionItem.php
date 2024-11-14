<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 
        'product_id', 
        'quantity', 
        'price', 
        'total'
    ];

    /**
     * Get the transaction that owns the item.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the product that this transaction item refers to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

