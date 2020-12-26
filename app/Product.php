<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'price', 'category', 'taxable', 'img'
    ];

    protected function category()
    {
        return $this->belongsTo('App\ProductCategory', 'id');
    }
}
