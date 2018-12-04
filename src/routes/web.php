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
    Route::resource('products','ProductController');
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
});
