<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Delivery extends Model
{
	use SoftDeletes;

	protected $table 		= 'delivery';
	protected $dates 		= ['deleted_at'];

	public function scopeAllDelivery($query)
	{
		return $query->select([
			'delivery.id as id_delivery',
			'delivery.is_pickup_first',
			'delivery.send_cost',
			'delivery.status',
			'delivery.courier as id_courier',
			'delivery.created_at as date',
			'users.name as courier_name',
			'customer.name as customer_name',
			'item.name as item_name',
			'delivery_detail.qty',
			'delivery_detail.selling_price',
			'delivery_detail.is_first_row',
		])
		->join('delivery_detail', 'delivery_detail.delivery_id', '=', 'delivery.id')
		->join('customer', 'customer.id', '=', 'delivery.customer')
		->join('item', 'item.id', '=', 'delivery_detail.item')
		->join('users', 'users.id', '=', 'delivery.courier');
	}

	public function scopeDelivery($query)
	{
		$query->select([
			'delivery.id as id_delivery',
			'delivery.is_pickup_first',
			'delivery.send_cost',
			'delivery.status',
			'delivery.created_at as date',
			'users.name as courier_name',
			'customer.name as customer_name',
			'item.name as item_name',
			'delivery_detail.qty',
			'delivery_detail.selling_price',
			'delivery_detail.is_first_row',
		])
		->join('delivery_detail', 'delivery_detail.delivery_id', '=', 'delivery.id')
		->join('customer', 'customer.id', '=', 'delivery.customer')
		->join('item', 'item.id', '=', 'delivery_detail.item')
		->join('users', 'users.id', '=', 'delivery.courier')
		->where('delivery.status', '==', '0');
	}

	public function scopeDeliveryActive($query)
	{
		return $query->select([
			'delivery.id as id_delivery',
			'delivery.is_pickup_first',
			'delivery.send_cost',
			'delivery.status',
			'delivery.courier as id_courier',
			'delivery.created_at as date',
			'users.name as courier_name',
			'customer.name as customer_name',
			'item.name as item_name',
			'delivery_detail.qty',
			'delivery_detail.selling_price',
			'delivery_detail.is_first_row',
		])
		->join('delivery_detail', 'delivery_detail.delivery_id', '=', 'delivery.id')
		->join('customer', 'customer.id', '=', 'delivery.customer')
		->join('item', 'item.id', '=', 'delivery_detail.item')
		->join('users', 'users.id', '=', 'delivery.courier')
		->where('delivery.status', '!=', '0');
	}

	public function scopeDeliveryActiveCourier($query,$user)
	{
		$query->select([
			'delivery.id as id_delivery',
			'delivery.is_pickup_first',
			'delivery.send_cost',
			'delivery.status',
			'delivery.created_at as date',
			'users.name as courier_name',
			'customer.name as customer_name',
			'item.name as item_name',
			'delivery_detail.qty',
			'delivery_detail.selling_price',
			'delivery_detail.is_first_row',
		])
		->join('delivery_detail', 'delivery_detail.delivery_id', '=', 'delivery.id')
		->join('customer', 'customer.id', '=', 'delivery.customer')
		->join('item', 'item.id', '=', 'delivery_detail.item')
		->join('users', 'users.id', '=', 'delivery.courier')
		->where('delivery.courier', $user->id)
		->where('delivery.status', '!=', '0');
	}

	public function scopeDeliveryCancel($query)
	{
		$query->select([
			'delivery.id as id_delivery',
			'delivery.is_pickup_first',
			'delivery.send_cost',
			'delivery.status',
			'delivery.courier as id_courier',
			'delivery.created_at as date',
			'delivery.deleted_at as cancel',
			'users.name as courier_name',
			'customer.name as customer_name',
			'item.name as item_name',
			'delivery_detail.qty',
			'delivery_detail.selling_price',
			'delivery_detail.is_first_row',
		])
		->join('delivery_detail', 'delivery_detail.delivery_id', '=', 'delivery.id')
		->join('customer', 'customer.id', '=', 'delivery.customer')
		->join('item', 'item.id', '=', 'delivery_detail.item')
		->join('users', 'users.id', '=', 'delivery.courier')
		->onlyTrashed();
	}

	public function scopeDeliveryById($query,$id_delivery)
	{
		return $query->select([
			'delivery.id as id_delivery',
			'delivery.is_pickup_first',
			'delivery.send_cost',
			'delivery.receiver',
			'delivery.received_proof',
			'delivery.status',
			'delivery.created_at as date',
			'delivery.deleted_at as cancel',
			'users.name as courier_name',
			'customer.name as customer_name',
			'customer.address',
			'customer.phone',
			'item.name as item_name',
			'delivery_detail.qty',
			'delivery_detail.selling_price',
			'delivery_detail.is_first_row',
		])
		->join('delivery_detail', 'delivery_detail.delivery_id', '=', 'delivery.id')
		->join('customer', 'customer.id', '=', 'delivery.customer')
		->join('item', 'item.id', '=', 'delivery_detail.item')
		->join('users', 'users.id', '=', 'delivery.courier')
		->where('delivery.id', $id_delivery)
		->withTrashed();
	}

	/*function scopeDeliveryActiveById($query, $id_delivery)
	{
		return $query->select([
			'delivery.id as id_delivery',
			'delivery.is_pickup_first',
			'delivery.send_cost',
			'delivery.receiver',
			'delivery.received_proof',
			'delivery.status',
			'delivery.created_at as date',
			'delivery.deleted_at as cancel',
			'users.name as courier_name',
			'customer.name as customer_name',
			'customer.phone',
			'item.name as item_name',
			'delivery_detail.qty',
			'delivery_detail.selling_price',
			'delivery_detail.is_first_row',
		])
		->join('delivery_detail', 'delivery_detail.delivery_id', '=', 'delivery.id')
		->join('customer', 'customer.id', '=', 'delivery.customer')
		->join('item', 'item.id', '=', 'delivery_detail.item')
		->join('users', 'users.id', '=', 'delivery.courier')
		->where('delivery.id', $id_delivery);
	}*/

	/* Utilities For Dashboard */

	public function scopeCountAllDelivery($query)
	{
		return $query->select('delivery.courier', 'users.name as courier_name', DB::raw('count(*) as total'))
		->join('users', 'users.id', '=', 'delivery.courier');
	}

	public function scopeDeliveryActiveHome($query)
	{
		return $query->select([
			'delivery.id as id_delivery',
		])
		->where('delivery.status', '!=', '0');
	}
}
