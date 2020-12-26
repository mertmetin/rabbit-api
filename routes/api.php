<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('users', 'Auth\RegisterController@register');
Route::get('/addresses/types', 'Address\AddressTypesController@get');
Route::post('users/password/recovery', 'Auth\ForgotPasswordController@sendPasswordResetCode');

/**
 * Search
 */
Route::get('search', 'Search\SearchController@get');

/**
 * Promotions
 */
Route::get('promotions', 'Promotions\PromotionsController@get');


/**
 * Lists
 */
Route::get('lists/products', 'Lists\ListsController@getProducts');

Route::group(['middleware' => ['bindings']], function () {
    Route::patch('users/{user}/activate', 'Auth\RegisterController@activateUser');
    Route::delete('users/{user}', 'UsersController@delete');
    Route::post('users/{user}/token/resend', 'Auth\RegisterController@resendCode');
    Route::patch('users/{user}/password/reset', 'Auth\ResetPasswordController@resetPassword');

    /**
    * Inventory
    */
    Route::get('inventory', 'Inventory\InventoryController@get');
    Route::post('inventory', 'Inventory\InventoryController@store');
    Route::put('inventory/{inventory}', 'Inventory\InventoryController@update');
    Route::delete('inventory/{inventory}', 'Inventory\InventoryController@destroy');

});

Route::group(['middleware' => ['auth:api', 'bindings']], function () {
    Route::get('user', 'UsersController@getUser');
    Route::patch('users/{user_id}/password/change', 'Auth\ChangePasswordController@changePassword');
    Route::put('users/{user_id}', 'UsersController@edit');

    /**
     * Addresses
     */
    Route::get('users/{user}/addresses', 'Address\AddressController@get');
    Route::post('users/{user}/addresses', 'Address\AddressController@add');
    Route::delete('users/{user}/addresses', 'Address\AddressController@destroy');

    /**
     * Stores
     */
    Route::post('stores', 'Store\StoreController@add');
    Route::get('stores', 'Store\StoreController@get');
    Route::get('stores/closest', 'Store\StoreController@getClosestStore');
    // Route::get('stores/{store}/categories', 'Store\StoreProductsController@getStoreProductCategories');
    // Route::get('stores/{store}/products', 'Store\StoreProductsController@getStoreProducts');

    /**
     * Orders
     */
    Route::get('orders', 'Orders\OrdersController@get');
    Route::get('orders/{order}', 'Orders\OrdersController@getOrder');
    Route::post('orders', 'Orders\OrdersController@store');
    Route::put('orders/{order}/close', 'Orders\OrdersController@closeOrder');
    Route::put('orders/{order}/cancel', 'Orders\OrdersController@cancelOrder');
    Route::delete('orders/{order}', 'Orders\OrdersController@destroy');

    /**
     * Checkouts
     */
    Route::post('checkouts', 'Orders\CheckoutController@store');

    /**
     * Payment Methods
     */
    Route::post('payment/methods', 'Payment\PaymentMethodsController@store');
    Route::get('payment/methods/{payment_method}', 'Payment\PaymentMethodsController@get');
    Route::put('payment/methods/{payment_method}', 'Payment\PaymentMethodsController@update');
    Route::delete('payment/methods/{payment_method}', 'Payment\PaymentMethodsController@delete');
});

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');


// Route::group([
//     'middleware' => 'api'

// ], function ($router) {
//     Route::post('login', 'Auth\LoginController@login');
//     Route::post('logout', 'Auth\LoginController@logout');
// });



