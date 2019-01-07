<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemCategory2 extends Model
{
    use SoftDeletes;

    protected $table = 'item_category2';

    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'name',
    ];

    public function Item() {
    	return $this->hasMany('App\Item', 'item_category2');
    }
}
