<?php

namespace Database\Seeders;

use App\Store;
use App\Product;
use App\Inventory;
use App\ProductCategory;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Main category (e.g. Water)
         */
        $category = ProductCategory::factory()->create(['title' => 'Water']);
        
        /**
         * Subcategory (e.g. Carbonated Water)
         */
        $subcategory = ProductCategory::factory()->create([
            'category_id' => $category->id, 'title' => 'Carbonated Water']);
        
        /**
         * Store
         */
        $store = Store::factory()->create();
        $products = Product::factory()->times(3)
            ->create(['category' => $subcategory->id])->toArray();

        foreach ($products as $product)
        {
            $inventory = new Inventory();
            $inventory->product_id = $product['id'];
            $inventory->store_id = $store->id;
            $inventory->quantity = 50;
            $inventory->save();
        }

        /**
         * Subcategory (e.g. Carbonated Water)
         */
        $subcategory = ProductCategory::factory()->create([
            'category_id' => $category->id, 'title' => 'Spring Water']);

        $products = Product::factory()->times(3)
            ->create(['category' => $subcategory->id])->toArray();

        foreach ($products as $product)
        {
            $inventory = new Inventory();
            $inventory->product_id = $product['id'];
            $inventory->store_id = $store->id;
            $inventory->quantity = 50;
            $inventory->save();
        }
    }
}
