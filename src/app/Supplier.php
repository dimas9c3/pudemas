<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Supplier extends Model
{
	use SoftDeletes;

	protected $table 	= 'supplier';

	protected $dates 	= ['deleted_at'];

	public function scopeSupplier($query)
	{
		DB::statement(DB::raw('set @rownum=0'));

		return $query->select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'id',
			'name',
			'email',
			'phone',
			'address',
		])
		->orderBy('name','asc')
		->get();
	}
}
