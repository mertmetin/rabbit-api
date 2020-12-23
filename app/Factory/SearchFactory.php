<?php

namespace App\Factory;

class SearchFactory 
{
    public $service;

    public static function init($service = 'algolia')
    {
        $factory = new SearchFactory();

        switch ($service)
        {
            case 'algolia':
                $service = new \App\AlgoliaSearch();
                break;
        }

        $factory->service = $service;

        return $factory;
    }
}