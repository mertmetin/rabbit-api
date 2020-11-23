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
Route::get('/promotions', 'Promotions\PromotionsController@get');


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

});

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

// Route::post('/activateUser', 'Auth\RegisterController@activateUser');
// Route::post('/resendCode', 'Auth\RegisterController@resendCode');
// Route::post('/sendPasswordResetCode', 'Auth\ForgotPasswordController@sendPasswordResetCode');
// Route::post('/resetPassword', 'Auth\ResetPasswordController@resetPassword');
// Route::post('/changePassword', 'Auth\ChangePasswordController@changePassword');
// Route::post('/editUser', 'UsersController@edit');
Route::post('/registerCustomer', 'Payment\CustomerController@register');
Route::post('/addCard', 'Payment\CardController@add');
Route::post('/deleteCard', 'Payment\CardController@delete');
Route::post('/getCards', 'Payment\CardController@get');
Route::post('/updateCard', 'Payment\CardController@update');
// Route::post('/getAddressTypes', 'Address\AddressTypesController@get');
// Route::post('/getAddresses', 'Address\AddressController@get');
// Route::post('/addAddress', 'Address\AddressController@add');
// Route::post('/deleteAddress', 'Address\AddressController@delete');
// Route::post('/editAddress', 'Address\AddressController@edit');
// Route::post('/getProducts', 'Product\ProductController@get');
// Route::post('/getProductCategories', 'Product\ProductCategoryController@get');
// Route::post('/getPromotions', 'Promotions\PromotionsController@get');
// Route::post('/getStore', 'Store\StoreController@getStore');
// Route::post('/getStoreProductCategories', 'Store\StoreProductsController@getStoreProductCategories');
// Route::post('/getStoreProducts', 'Store\StoreProductsController@getStoreProducts');

    // Route::post('getUser', 'UsersController@gestUser');


// Route::middleware('auth:api')->post('/getUser', function(Request $request) {
//          error_log(json_encode('here'));
// });


// error_log(json_encode($_POST));



// Route::post('getUser', 'UsersController@getUser');