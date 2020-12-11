<?php

namespace App\Http\Controllers\Inventory;

use App\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class InventoryController extends Controller
{
    protected function get(Request $request): Response
    {
        $store = $request->input('store');

        if ($store)
            return new Response(Inventory::where('store_id', $store)->with('product')->get());

        return new Response(Inventory::with('product')->get());
    }

    protected function store(Request $request): Response
    {
        $data = $request->validate([
            'store_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]); 

        $inventory = Inventory::create([
            'store_id' => $data['store_id'],
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity']
        ]);

        return new Response($inventory->id, 201);
    }

    protected function update(Request $request, Inventory $inventory): Response
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]); 

        Inventory::where('id', $inventory->id)->update(['quantity' => $data['quantity']]);
        $inventory = Inventory::findOrFail($inventory->id);
        
        return new Response($inventory->toArray(), 200);
    }

    protected function destroy(Request $request, Inventory $inventory): Response
    {
        $inventory->delete();

        return new Response([], 204);
    }
}