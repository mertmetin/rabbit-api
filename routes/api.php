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
Route::post('users/{user_id}/activate', 'Auth\RegisterController@activateUser');
Route::post('users/{user_id}/token/resend', 'Auth\RegisterController@resendCode');
Route::post('users/password/recovery', 'Auth\ForgotPasswordController@sendPasswordResetCode');
Route::patch('users/{user_id}/password/reset', 'Auth\ResetPasswordController@resetPassword');

Route::get('/addresses/types', 'Address\AddressTypesController@get');

/**
 * Promotions
 */
Route::get('promotions', 'Promotions\PromotionsController@get');

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('user', 'UsersController@getUser');
    Route::patch('users/{user_id}/password/change', 'Auth\ChangePasswordController@changePassword');
    Route::put('users/{user_id}', 'UsersController@edit');

    /**
     * Addresses
     */
    Route::get('users/{user_id}/addresses', 'Address\AddressController@get');
    Route::post('users/{user_id}/addresses', 'Address\AddressController@add');
    Route::delete('users/{user_id}/addresses/{address_id}', 'Address\AddressController@delete');

    /**
     * Stores
     */
    Route::post('/stores/', 'Store\StoreController@getStore');
    Route::get('stores/{store_id}/categories', 'Store\StoreProductsController@getStoreProductCategories');
    Route::get('stores/{store_id}/products', 'Store\StoreProductsController@getStoreProducts');

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