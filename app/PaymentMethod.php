<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type_id'
    ];

    protected function type()
    {
        return $this->belongsTo('App\PaymentMethodTypes', 'id');
    }
}
