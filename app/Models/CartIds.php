<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartIds extends Model
{
    protected $fillable = [
        'cartId',
        'total',
        'amountTotal',
        'paymentStatus',
        'paymentMethod',
        'customerName',
    ];
}
