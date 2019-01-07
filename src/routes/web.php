<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
});

//User Class Route
Route::group(['middleware' => ['auth'], ['as' => 'user-route']], function() {
	Route::get('/user/selectCourier', 'UserController@selectCourier');
});

// Customer Class Route
Route::group(['middleware' => ['auth'], ['as' => 'customer-route']], function() {
	Route::get('/customer', 'CustomerController@index')->name('customer');
	Route::get('/customer/getCustomer', 'CustomerController@getCustomer')->name('getCustomer');
	Route::post('/customer/getCustomerById', 'CustomerController@getCustomerById')->name('getCustomerById');
	Route::get('/customer/getCustomerType', 'CustomerController@getCustomerType')->name('getCustomerType');
	Route::post('/customer/storeCustomer','CustomerController@storeCustomer')->name('storeCustomer');
	Route::post('/customer/storeCustomerType','CustomerController@storeCustomerType')->name('storeCustomerType');
	Route::post('/customer/destroyCustomer', 'CustomerController@destroyCustomer')->name('destroyCustomer');
	Route::post('/customer/destroyCustomerType','CustomerController@destroyCustomerType')->name('destroyCustomerType');
	Route::post('/customer/updateCustomer','CustomerController@updateCustomer')->name('updateCustomer');
	Route::post('/customer/updateCustomerType','CustomerController@updateCustomerType')->name('updateCustomerType');
	Route::get('/customer/selectCustomerType','CustomerController@selectCustomerType')->name('selectCustomerType');
	Route::get('/customer/selectCustomer', 'CustomerController@selectCustomer');
});

// Item Class Route
Route::group(['middleware' => ['auth'], ['as' => 'item-route']], function() {
	Route::get('/item', 'ItemController@index')->name('item');
	Route::get('/item/getItem', 'ItemController@getItem')->name('getItem');
	Route::post('/item/getItemPickup', 'ItemController@getItemPickup');
	Route::post('/item/getItemDelivery', 'ItemController@getItemDelivery');
	Route::post('/item/getItemById', 'ItemController@getItemById')->name('getItemById');
	Route::get('/item/getItemCategory1', 'ItemController@getItemCategory1')->name('getItemCategory1');
	Route::get('/item/getItemCategory2', 'ItemController@getItemCategory2')->name('getItemCategory2');
	Route::post('/item/storeItem', 'ItemController@storeItem')->name('storeItem');
	Route::post('/item/storeItemPickup', 'ItemController@storeItemPickup');
	Route::post('/item/storeItemCategory1', 'ItemController@storeItemCategory1')->name('storeItemCategory1');
	Route::post('/item/storeItemCategory2', 'ItemController@storeItemCategory2')->name('storeItemCategory2');
	Route::post('/item/destroyItem', 'ItemController@destroyItem')->name('destroyItem');
	Route::post('/item/destroyItemPickup', 'ItemController@destroyItemPickup');
	Route::post('/item/destroyItemDelivery', 'ItemController@destroyItemDelivery');
	Route::post('/item/destroyItemCategory1', 'ItemController@destroyItemCategory1')->name('destroyItemCategory1');
	Route::post('/item/destroyItemCategory2', 'ItemController@destroyItemCategory2')->name('destroyItemCategory2');
	Route::post('/item/updateItem', 'ItemController@updateItem')->name('updateItem');
	Route::post('/item/updateItemCategory1', 'ItemController@updateItemCategory1')->name('updateItemCategory1');
	Route::post('/item/updateItemCategory2', 'ItemController@updateItemCategory2')->name('updateItemCategory2');
	Route::get('/item/selectItem', 'ItemController@selectItem')->name('selectItem');
	Route::get('/item/selectItemCategory1', 'ItemController@selectItemCategory1')->name('selectItemCategory1');
	Route::get('/item/selectItemCategory2', 'ItemController@selectItemCategory2')->name('selectItemCategory2');
});

//Supplier Class Route
Route::group(['middleware' => ['auth'], ['as' => 'supplier-route']], function() {
	Route::get('/supplier', 'SupplierController@index')->name('supplier');
	Route::get('/supplier/getSupplier', 'SupplierController@getSupplier')->name('getSupplier');
	Route::post('/supplier/getSupplierById', 'SupplierController@getSupplierById')->name('getSupplierById');
	Route::post('/supplier/storeSupplier', 'SupplierController@storeSupplier')->name('storeSupplier');
	Route::post('/supplier/destroySupplier', 'SupplierController@destroySupplier')->name('destroySupplier');
	Route::post('/supplier/updateSupplier', 'SupplierController@updateSupplier')->name('updateSupplier');
	Route::get('/supplier/selectSupplier', 'SupplierController@selectSupplier')->name('selectSupplier');
});

//Pick Up Class Route
Route::group(['middleware' => ['auth'], ['as' => 'pickup-route']], function() {
	Route::get('/pickup/active', 'PickupController@pickupActive')->name('pickupActive');
	Route::get('/pickup/activeCourier', 'PickupController@pickupActiveCourier')->name('pickupActiveCourier');
	Route::get('/pickup/getPickupActive', 'PickupController@getPickupActive');
	Route::get('/pickup/getPickupActiveCourier', 'PickupController@getPickupActiveCourier');
	Route::get('/pickup/getPickupActiveById/{id_pickup}', 'PickupController@getPickupActiveById');
	Route::get('/pickup/create', 'PickupController@create')->name('createPickup');
	Route::post('/pickup/storePickup', 'PickupController@storePickup');
	Route::get('/pickup/acceptPickupJob', 'PickupController@acceptPickupJob')->name('acceptPickupJob');
	Route::get('/pickup/updatedActivity', 'PickupController@updatedActivity');

});

