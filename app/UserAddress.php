<?php

namespace App;

use App\AddressType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserAddress extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'label',
        'address_type',
        'address_line_1',
        'address_line_2',
        'zone_code',
        'postal_code',
        'city',
        'country_code',
        'latitude',
        'longitude',
        'notes'
    ];

    public function address_type()
    {
        return $this->belongsTo(AddressType::class, 'address_type');
    }
}