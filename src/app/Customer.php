<?php

namespace App;

use App\Customer;
use App\CustomerType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Customer extends Model
{
	use SoftDeletes;

	protected $table = 'customer';

	protected $dates = ['deleted_at'];

	function getCustomer()
	{
		DB::statement(DB::raw('set @rownum=0'));

		$customer = Customer::select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'customer.id',
			'customer.name',
			'customer_type.name as type',
			'customer.email',
			'customer.phone',
			'customer.address'
		])
		->join('customer_type', 'customer_type.id', '=', 'customer.customer_type')
		->orderBy('customer.name','asc')
		->get();

		return $customer;
	}

}
