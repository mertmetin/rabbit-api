<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    protected function get(Request $request): Response
    {
        $cities = City::all()->pluck('name');

        return new Response($cities);
    }
}