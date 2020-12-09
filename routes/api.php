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
 * Promotions
 */
Route::get('promotions', 'Promotions\PromotionsController@get');

Route::group(['middleware' => ['bindings']], function () {
    Route::patch('users/{user}/activate', 'Auth\RegisterController@activateUser');
    Route::delete('users/{user}', 'UsersController@delete');
    Route::post('users/{user}/token/resend', 'Auth\RegisterController@resendCode');
    Route::patch('users/{user}/password/reset', 'Auth\ResetPasswordController@resetPassword');
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
    Route::delete('users/{user}/addresses', 'Address\AddressController@delete');

    /**
     * Stores
     */
    Route::post('stores', 'Store\StoreController@add');
    Route::get('stores', 'Store\StoreController@get');
    Route::get('stores/closest', 'Store\StoreController@getClosestStore');
    Route::get('stores/{store}/categories', 'Store\StoreProductsController@getStoreProductCategories');
    Route::get('stores/{store}/products', 'Store\StoreProductsController@getStoreProducts');

    /**
     * Payment
     */
    Route::post('payment/customers', 'Payment\CustomerController@register');
    Route::post('payment/cards', 'Payment\CardController@add');
    Route::delete('payment/cards', 'Payment\CardController@delete');
    Route::get('payment/cards', 'Payment\CardController@get');
    Route::patch('payment/cards', 'Payment\CardController@update');
});

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');


// Route::group([
//     'middleware' => 'api'

// ], function ($router) {
//     Route::post('login', 'Auth\LoginController@login');
//     Route::post('logout', 'Auth\LoginController@logout');
// });



