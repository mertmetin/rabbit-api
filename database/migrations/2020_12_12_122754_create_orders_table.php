<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            // $table->integer('store_id')->unsigned();
            // $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            // $table->integer('payment_method_id')->unsigned();
            // $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            // $table->decimal('total', 8, 2)->nullable();
            // $table->decimal('total_tax', 8, 2)->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
