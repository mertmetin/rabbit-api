<?php

namespace App\Http\Controllers\Store;

use App\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    const EARTH_RADIUS = 6371;
    const MAX_STORE_DISTANCE = 10;

    protected function store(Request $request): Response
    {
        $data = $request->validate([
            'name' => 'required|string',
            'coordinates' => 'required'
        ]); 

        try {
            $store = Store::create([
                'name' => $data['name'],
                'coordinates' => $data['coordinates']
            ]);
        } catch (\Exception $e) {
            print($e);
        }

        return new Response(['store_id' => $store->id], 201);
    }

    protected function get(Request $request): Response
    {
        $stores = Store::all();

        return new Response($stores->toArray());
    }

    protected function getClosestStore(Request $request): Response
    {
        $data = $request->validate([
            'lat' => 'required',
            'lng' => 'required'
        ]); 

        $lat = $data['lat'];
        $lng = $data['lng'];

        $stores = Store::all();
        $closestStore = false;

        foreach ($stores as $key => $store) 
        {
            $coords = $store['coordinates'];
            $storeLat = $coords->getLat();
            $storeLng = $coords->getLng();
            
            $dist = $this->getDistance($storeLat, $storeLng, $lat, $lng);

            if ($dist < self::MAX_STORE_DISTANCE)
            {
                $closestStore = $store;
                $min = $dist;
            }
        }

        return new Response($closestStore);
    }

    function getDistance($latitude1, $longitude1, $latitude2, $longitude2) 
    {        
        $dLat = deg2rad($latitude2 - $latitude1);  
        $dLon = deg2rad($longitude2 - $longitude1);  
        
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) 
            * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
        $c = 2 * asin(sqrt($a));  
        $d = self::EARTH_RADIUS * $c;  
      
        return $d;  
    }  
}
