<?php

namespace App;

use App\StripeCustomer;
use Illuminate\Database\Eloquent\Model;

class StripeCard extends Model
{
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'customer_id', 'payment_method_id', 'fingerprint', 'last4', 'exp_month', 'exp_year', 'brand'
    ];

    public function customer()
    {
        return $this->belongsTo(StripeCustomer::class, 'customer_id', 'customer_id');
    }
}
