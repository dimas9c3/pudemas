<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerType extends Model
{
	use SoftDeletes;

    protected $table = 'customer_type';

    protected $fillable = [
        'name',
    ];

    protected $dates = ['deleted_at'];

    public function Customer() 
    {
    	return $this->hasMany('App\Customer', 'customer_type');	
    }
}
