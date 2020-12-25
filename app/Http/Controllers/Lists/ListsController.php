<?php

namespace App\Http\Controllers\Lists;

use App\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class ListsController extends Controller
{
    protected function getProducts(Request $request): Response
    {
        $data = $request->validate([
            'store_id' => 'required|integer'
        ]); 

        $result = Redis::get($data['store_id'] . '_products');
        
        return new Response($result);
    }
}
