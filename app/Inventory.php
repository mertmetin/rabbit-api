<?php

namespace App;

use App\Product;
use App\Events\InventoryUpdated;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use Searchable;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => InventoryUpdated::class
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory';

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
