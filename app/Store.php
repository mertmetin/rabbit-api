<?php

namespace App;

use TCG\Voyager\Traits\Spatial;
use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use Spatial;
    use SpatialTrait;
    use HasFactory;

    public $timestamps = false;

    protected $spatial = ['coordinates'];    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'coordinates'
    ];

    protected $spatialFields = [
        'coordinates'
    ];
}    
