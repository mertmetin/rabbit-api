<?php

namespace App\Listeners;

use App\Inventory;
use App\ProductCategory;
use App\Events\InventoryUpdated;
use Illuminate\Support\Facades\Redis;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateInventoryTree
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

        //
    }

    /**
     * Handle the event.
     *
     * @param  InventoryUpdated  $event
     * @return void
     */
    public function handle(InventoryUpdated $event)
    {
        $inventory = $event->inventory;
        $storeId = $inventory->store_id;
        $productId = $inventory->product_id;
    
        $items = Inventory::where('store_id', $storeId)->get();
        $subcategories = [];

        foreach ($items as $item)
        {
            $product = $item->product;
            $category = ProductCategory::
                where('id', $product->category)->first();
            $categoryId = $category->id;

            if (empty($subcategories[$categoryId]))
            {
                $subcategories[$categoryId] = $category->toArray();
                $subcategories[$categoryId]['data'] = [];
            }

            $subcategories[$categoryId]['data'][] = $product->toArray();
        }

        $categories = ProductCategory::where('category_id', null)->get()->toArray();

        foreach ($categories as $key => $category)
        {   
            $categoryId = $category['id'];
            $arr = [];

            foreach ($subcategories as $subcategory)
            {
                if ($subcategory['category_id'] == $categoryId)
                    $arr []= $subcategory;
            }

            $categories[$key]['subcategories'] = $arr;
        }

        Redis::set($storeId . '_products', json_encode($categories));
    }
}
