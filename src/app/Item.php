<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
	use SoftDeletes;

    protected $table = 'item';

    protected $dates = ['deleted_at'];

    public function ItemCategory1() 
    {
    	return $this->belongsTo('App\ItemCategory1', 'item_category1');
    } 

    public function ItemCategory2() 
    {
    	return $this->belongsTo('App\ItemCategory2', 'item_category2');
    } 
}
