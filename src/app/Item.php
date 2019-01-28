<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Item extends Model
{
	use SoftDeletes;

    protected $table = 'item';

    protected $dates = ['deleted_at'];

    public function scopeItem($query)
    {
        DB::statement(DB::raw('set @rownum=0'));

        return $query->select([
            DB::raw('@rownum  := @rownum + 1 AS rownum'),
            'item.id',
            'item.image',
            'item.name',
            'item.purchase_price',
            'item.selling_price',
            'item_category1.name as kategori',
            'item_category2.name as merk',
        ])
        ->join('item_category1','item_category1.id','=','item.item_category1')
        ->join('item_category2','item_category2.id','=','item.item_category2');
    }
}
