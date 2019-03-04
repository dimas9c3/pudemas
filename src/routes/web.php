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

Route::get('/', 'FrontController@index');

Route::group([['as' => 'front-route']], function() {
	Route::get('/about', 'FrontController@about')->name('front.about');
	Route::get('/cekresi', 'FrontController@checkResi');
});

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
	Route::get('/customer/report', 'CustomerController@reportCustomer');
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
	Route::post('/item/storeItemDelivery', 'ItemController@storeItemDelivery');
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
	Route::get('/item/report', 'ItemController@reportItem');
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
	Route::get('/supplier/report', 'SupplierController@reportSupplier');
});

//Pick Up Class Route
Route::group(['middleware' => ['auth'], ['as' => 'pickup-route']], function() {
	Route::get('/pickup', 'PickupController@index')->name('pickup');
	Route::get('/pickup/active', 'PickupController@pickupActive')->name('pickupActive');
	Route::get('/pickup/activeCourier', 'PickupController@pickupActiveCourier')->name('pickupActiveCourier');
	Route::get('/pickup/cancel', 'PickupController@pickupCancel')->name('pickupCancel');
	Route::get('/pickup/getPickup', 'PickupController@getPickup');
	Route::get('/pickup/getPickupActive', 'PickupController@getPickupActive');
	Route::get('/pickup/getPickupActiveCourier', 'PickupController@getPickupActiveCourier');
	Route::get('/pickup/getPickupCancel', 'PickupController@getPickupCancel')->name('getPickupCancel');
	Route::get('/pickup/getPickupById/{id_pickup}', 'PickupController@getPickupById');
	Route::post('/pickup/getPickupLocation', 'PickupController@getPickupLocation');
	Route::get('/pickup/create', 'PickupController@create')->name('createPickup');
	Route::post('/pickup/storePickup', 'PickupController@storePickup');
	Route::post('/pickup/storeLocation', 'PickupController@storeLocation');
	Route::get('/pickup/changePickupJob', 'PickupController@changePickupJob')->name('changePickupJob');
	Route::get('/pickup/cancelPickup', 'PickupController@cancelPickup')->name('cancelPickup');
	Route::get('/pickup/recyclePickup', 'PickupController@recyclePickup')->name('recyclePickup');
	Route::get('/pickup/updatedActivity', 'PickupController@updatedActivity');
	Route::post('/pickup/report', 'PickupController@reportPickup');
	Route::get('/pickup/note/{id}', 'PickupController@notePickup');
});

//Delivery Class Route
Route::group(['middleware' => ['auth'], ['as' => 'delivery-route']], function() {
	Route::get('/delivery', 'DeliveryController@index')->name('delivery');
	Route::get('/delivery/activeDelivery', 'DeliveryController@activeDelivery')->name('activeDelivery');
	Route::get('/delivery/activeDeliveryCourier', 'DeliveryController@activeDeliveryCourier')->name('activeDeliveryCourier');
	Route::get('/delivery/deliveryCancel', 'DeliveryController@deliveryCancel');
	Route::get('/delivery/getDelivery', 'DeliveryController@getDelivery');
	Route::get('/delivery/getDeliveryActive', 'DeliveryController@getDeliveryActive');
	Route::get('/delivery/getDeliveryActiveCourier', 'DeliveryController@getDeliveryActiveCourier');
	Route::get('/delivery/getDeliveryCancel', 'DeliveryController@getDeliveryCancel');
	Route::get('/delivery/getDeliveryById/{id_delivery}', 'DeliveryController@getDeliveryById');
	Route::post('/delivery/getDeliveryLocation', 'DeliveryController@getDeliveryLocation');
	Route::get('/delivery/createDelivery', 'DeliveryController@createDelivery')->name('createDelivery');
	Route::post('/delivery/storeDelivery', 'DeliveryController@storeDelivery');
	Route::post('/delivery/storeLocation', 'DeliveryController@storeLocation');
	Route::get('/delivery/cancelDelivery', 'DeliveryController@cancelDelivery')->name('cancelDelivery');
	Route::get('/delivery/recycleDelivery', 'DeliveryController@recycleDelivery')->name('recycleDelivery');
	Route::get('/delivery/changeDeliveryJob', 'DeliveryController@changeDeliveryJob')->name('changeDeliveryJob');
	Route::post('/delivery/finishDelivery', 'DeliveryController@finishDelivery');
	Route::post('/delivery/report', 'DeliveryController@reportDelivery');
	Route::get('/delivery/invoice/{id}', 'DeliveryController@invoiceDelivery');
});

//Courier Class Route
Route::group(['middleware' => ['auth'], ['as' => 'courier-route']], function() {
	Route::get('/courier', 'CourierController@index')->name('courier.index');
});

//Other Expenses
Route::group(['middleware' => ['auth'], ['as' => 'other-expenses-route']], function() {
	Route::get('/other_expenses', 'OtherExpensesController@index')->name('otherExpenses');
	Route::get('/other_expenses/getOtherExpenses', 'OtherExpensesController@getOtherExpenses');
	Route::post('other_expenses/storeOtherExpenses', 'OtherExpensesController@storeOtherExpenses');
	Route::post('/other_expenses/destroyOtherExpenses', 'OtherExpensesController@destroyOtherExpenses');
	Route::post('/other_expenses/updateOtherExpenses', 'OtherExpensesController@updateOtherExpenses');
	Route::get('/other_expenses/report', 'OtherExpensesController@reportExpenses');
});

//Setting Route
Route::group(['middleware' => ['auth'], ['as' => 'setting-route']], function() {
	Route::get('/setting', 'SettingController@index')->name('setting.index');
	Route::post('/setting/updateSetting', 'SettingController@updateSetting');
});




