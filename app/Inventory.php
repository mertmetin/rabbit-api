<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use App\Product;

class Inventory extends Model
{
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id', 'product_id', 'quantity'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        $productId = $array['product_id'];
        $product = Product::where('id', $productId)->first()->toArray();
        $array['title'] = $product['title'];
        $array['description'] = $product['description'];
        $array['image'] = $product['image'];

        return $array;
    }
}
