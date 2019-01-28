<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class OtherExpenses extends Model
{
    use SoftDeletes;

    protected $table 			= 'other_expenses';

    protected $dates 			= ['deleted_at'];

    public function scopeOtherExpenses($query)
	{
		DB::statement(DB::raw('set @rownum=0'));

		return $query->select([
			DB::raw('@rownum  := @rownum  + 1 AS rownum'),
			'other_expenses.id',
			'other_expenses.subject',
			'other_expenses.amount',
			'other_expenses.date',
			'other_expenses.created_by as id_created_by',
			'users.name as created_by',
		])
		->join('users', 'users.id', '=', 'other_expenses.created_by');
		
	}
}
