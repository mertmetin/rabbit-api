<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'img'
    ];

    public function parent()
    {
        return $this->belongsTo('App\ProductCategory', 'category_id');
    }

    protected function categories()
    {
        return $this->belongsTo('App\ProductCategory', 'category_id');
    }

    protected function subCategories()
    {
        return $this->hasMany('App\ProductCategory', 'category_id');
    }
}
