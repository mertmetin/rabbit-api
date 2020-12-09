<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StoreProduct;
use App\Product;
use App\ProductCategory;
use Illuminate\Support\Facades\DB;
use \Exception;
use App\Store;

class StoreProductsController extends Controller
{
    protected function getStoreProductCategories(Request $request, Store $store)
    {
        $categories = [];
        $storeProducts = StoreProduct::where('store_id', $store->id)->get();

        foreach ($storeProducts as $storeProduct)
        {
            $categoryId = $storeProduct->product['category'];
            $category = ProductCategory::find($categoryId);

            if ($category->parent)
            {
                $parent = $category->parent->toArray();
                $categoryId = $parent['category_id'];

                if (empty($categories[$categoryId]))
                {
                    $parent['categories'] = [];
                    $categories[$categoryId] = $parent;
                }   

                $category = $category->toArray();
                unset($category['parent']);
                $categories[$categoryId]['categories'] []= $category;
            }
            else {
                $categories[$categoryId] = $category->toArray();
            }
        }

        return array_values($categories);
    }

    protected function getStoreProducts(Request $request, Store $store)
    {
        $category = $request->input('category');

        $storeProducts = StoreProduct::
                where('store_id', $store->id)->with('product')->get();

        if ($storeProducts->isEmpty())
            return;

        $categoryIds = ProductCategory::find($category)
            ->subCategories->pluck('id')->toArray();

        $products = [];

        foreach ($storeProducts as $storeProduct)
        {
            $product = $storeProduct->product;
            $category = $product->category;

            if (!in_array($category, $categoryIds))
                continue;

            if (empty($products[$category]))
            {
                $products[$category] = ProductCategory::where('id', $category)->first()->toArray();
                $products[$category]['data'] = [[]];
            }
            
            $products[$category]['data'] [0][]= $product;
        }

        return array_values($products);
    }
}