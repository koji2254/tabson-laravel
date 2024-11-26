<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{

    protected $fillable = [
        'productId',
        'itemId',
        'cartId',
        'price',
        'qty',
        'description',
        'productTitle',
    ];

}
