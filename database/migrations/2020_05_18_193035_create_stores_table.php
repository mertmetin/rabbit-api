<?php

use Illuminate\Database\Migrations\Migration;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Store;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->geometry('coordinates');
        });
        $store = new Store();
        $store->name = 'Ottawa Center';
        $store->coordinates = new Point(45.4215, -75.6972);
        $store->save();
        $store = new Store();
        $store->name = 'Ottawa East';
        $store->coordinates = new Point(45.4558 , -75.5047);
        $store->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
