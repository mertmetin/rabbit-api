<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Store;

class StoreController extends Controller
{
    protected function add(Request $request): Response
    {
        $name = $request->input('name');
        $coordinates = $request->input('coordinates');

        if (!$name || !$coordinates)
            throw new \Exception('Invalid request.');

        try {
            $user = Store::create([
                'name' => $name,
                'coordinates' => $coordinates
            ]);
        } catch (\Exception $e) {
            print($e);
        }

        return new Response([], 201);
    }

    protected function get(Request $request): Response
    {
        $stores = Store::all();

        return new Response($stores->toArray());
    }

    protected function getClosestStore(Request $request)
    {
        $addressLat = $request->input('lat');
        $addressLng = $request->input('lng');

        if (!$addressLat || !$addressLng)
            throw new \Exception('Invalid request.');

        $stores = Store::all();
        $closestStore = false;
        $min = 11;

        foreach ($stores as $key => $store) {
            $storeLat = $store['coordinates']->getLat();
            $storeLng = $store['coordinates']->getLng();
            
            $dist = $this->getDistance($storeLat, $storeLng, $addressLat, $addressLng);

            if ($dist < $min)
            {
                $closestStore = $store;
                $min = $dist;
            }
        }

        return $closestStore;
    }

    function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {  
        $earth_radius = 6371;  
      
        $dLat = deg2rad($latitude2 - $latitude1);  
        $dLon = deg2rad($longitude2 - $longitude1);  
        
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
        $c = 2 * asin(sqrt($a));  
        $d = $earth_radius * $c;  
      
        return $d;  
}  
}
