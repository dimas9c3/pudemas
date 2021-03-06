<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Pickup extends Model
{
	use SoftDeletes;

	protected $table 		= 'pick_up';

	protected $dates 		= ['deleted_at'];

	public function scopePickup($query)
	{
		$query->select([
			'pick_up.id as id_pickup',
			'users.name as courier_name',
			'pick_up.type',
			'pick_up.is_send_to_customer',
			'pick_up.status',
			'pick_up.created_at as date',
			'supplier.name as supplier_name',
			'item.name as item_name',
			'pick_up_detail.qty',
			'pick_up_detail.purchase_price',
			'pick_up_detail.is_first_row',
		])
		->join('pick_up_detail', 'pick_up_detail.pick_up_id', '=', 'pick_up.id')
		->join('supplier', 'supplier.id', '=', 'pick_up_detail.supplier')
		->join('item', 'item.id', '=', 'pick_up_detail.item')
		->join('users', 'users.id', '=', 'pick_up.courier')
		->where('pick_up.status', '==', '0');
	}

	public function scopePickupActive($query)
	{
		$query->select([
			'pick_up.id as id_pickup',
			'pick_up.courier as id_courier',
			'users.name as courier_name',
			'pick_up.type',
			'pick_up.is_send_to_customer',
			'pick_up.status',
			'supplier.name as supplier_name',
			'item.name as item_name',
			'pick_up_detail.qty',
			'pick_up_detail.purchase_price',
			'pick_up_detail.is_first_row',
		])
		->join('pick_up_detail', 'pick_up_detail.pick_up_id', '=', 'pick_up.id')
		->join('supplier', 'supplier.id', '=', 'pick_up_detail.supplier')
		->join('item', 'item.id', '=', 'pick_up_detail.item')
		->join('users', 'users.id', '=', 'pick_up.courier')
		->where('pick_up.status', '!=', '0');
	}

	public function scopePickupActiveCourier($query,$user)
	{
		$query->select([
			'pick_up.id as id_pickup',
			'users.name as courier_name',
			'pick_up.type',
			'pick_up.is_send_to_customer',
			'pick_up.status',
			'supplier.name as supplier_name',
			'item.name as item_name',
			'pick_up_detail.qty',
			'pick_up_detail.purchase_price',
			'pick_up_detail.is_first_row',
		])
		->join('pick_up_detail', 'pick_up_detail.pick_up_id', '=', 'pick_up.id')
		->join('supplier', 'supplier.id', '=', 'pick_up_detail.supplier')
		->join('item', 'item.id', '=', 'pick_up_detail.item')
		->join('users', 'users.id', '=', 'pick_up.courier')
		->where('pick_up.courier', $user->id)
		->where('pick_up.status', '!=', '0');
	}

	public function scopePickupCancel($query)
	{
		$query->select([
			'pick_up.id as id_pickup',
			'pick_up.courier as id_courier',
			'users.name as courier_name',
			'pick_up.type',
			'pick_up.is_send_to_customer',
			'pick_up.status',
			'pick_up.deleted_at as cancel',
			'pick_up.created_at as date',
			'supplier.name as supplier_name',
			'item.name as item_name',
			'pick_up_detail.qty',
			'pick_up_detail.purchase_price',
			'pick_up_detail.is_first_row',
		])
		->join('pick_up_detail', 'pick_up_detail.pick_up_id', '=', 'pick_up.id')
		->join('supplier', 'supplier.id', '=', 'pick_up_detail.supplier')
		->join('item', 'item.id', '=', 'pick_up_detail.item')
		->join('users', 'users.id', '=', 'pick_up.courier')
		->onlyTrashed();
	}

	public function scopePickupById($query,$id_pickup)
	{
		$query->select([
			'pick_up.id as id_pickup',
			'users.name as courier_name',
			'pick_up.type',
			'pick_up.is_send_to_customer',
			'pick_up.status',
			'pick_up.created_at as date',
			'pick_up.deleted_at as cancel',
			'supplier.name as supplier_name',
			'item.name as item_name',
			'pick_up_detail.qty',
			'pick_up_detail.purchase_price',
			'pick_up_detail.is_first_row',
		])
		->join('pick_up_detail', 'pick_up_detail.pick_up_id', '=', 'pick_up.id')
		->join('supplier', 'supplier.id', '=', 'pick_up_detail.supplier')
		->join('item', 'item.id', '=', 'pick_up_detail.item')
		->join('users', 'users.id', '=', 'pick_up.courier')
		->where('pick_up.id', $id_pickup)
		->withTrashed();
	}

	/* Utilities For Dashboard */

	public function scopePickupCourierHome($query, $courier)
	{
		return $query->select([
			'pick_up.id as id_pickup',
			'pick_up.type',
			'pick_up.is_send_to_customer',
			'pick_up.status',
		])
		->where('pick_up.status', '3')
		->where('pick_up.is_send_to_customer', '0')
		->where('pick_up.courier', $courier);
	}

	public function scopeCountAllPickup($query)
	{
		return $query->select('pick_up.courier', 'users.name as courier_name', DB::raw('count(*) as total'))
		->join('users', 'users.id', '=', 'pick_up.courier');
	}

	public function scopePickupActiveHome($query)
	{
		$query->select([
			'pick_up.id as id_pickup',
		])
		->where('pick_up.status', '!=', '0');
	}

}
