<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Factory\SearchFactory;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    protected function get(Request $request): Response
    {   
        $data = $request->validate([
            'index' => 'required',
            'q' => 'required|min:3',
            'store_id' => 'required|integer'
        ]); 

        $search = SearchFactory::init();
        $result = $search->service->queryIndex($data['store_id'], $data['index'], $data['q']);

        return new Response($result, 200);
    }
}
