<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'store_id', 'payment_method_id', 'user_address_id', 'total', 'total_tax'
    ];
}
