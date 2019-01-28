<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
	use SoftDeletes;

	protected $table 		= 'delivery';
	protected $dates 		= ['deleted_at'];

	function getDelivery()
	{
		$active     = Delivery::select([
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
		->where('delivery.status', '==', '0')
		->orderBy('delivery.created_at', 'DESC')
		->orderBy('delivery_detail.is_first_row', 'DESC')
		->get();

		return $active;
	}

	function getDeliveryActive()
	{
		$active     = Delivery::select([
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
		->where('delivery.status', '!=', '0')
		->orderBy('delivery.created_at', 'DESC')
		->orderBy('delivery_detail.is_first_row', 'DESC')
		->get();

		return $active;
	}

	function getDeliveryActiveCourier($user)
	{
		$active     = Delivery::select([
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
		->where('delivery.status', '!=', '0')
		->get();

		return $active;
	}

	function getDeliveryCancel()
	{
		$active     = Delivery::select([
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
		->onlyTrashed()
		->orderBy('delivery.created_at', 'DESC')
		->orderBy('delivery_detail.is_first_row', 'DESC')
		->get();

		return $active;
	}

	function getDeliveryActiveById($id_delivery)
	{
		$delivery         = Delivery::select([
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
		->where('delivery.id', $id_delivery)
		->withTrashed()
		->get();

		return $delivery;
	}
}