<?php

namespace App;

class AlgoliaSearch
{
    function __construct()
    {
        $this->client = \Algolia\AlgoliaSearch\SearchClient::create(env('ALGOLIA_APP_ID'),
             env('ALGOLIA_SECRET'));
    }

    function queryIndex($storeId, $index, $q)
    {   
        error_log($storeId);
        $index = $this->client->initIndex($index);
        $index->setSettings([
            'searchableAttributes' => [
                'title',
                'description'
            ]
        ]);
        $result = $index->search($q, [
            // 'filters' => "store_id=$storeId"
        ]);

        return $result;
    }
}