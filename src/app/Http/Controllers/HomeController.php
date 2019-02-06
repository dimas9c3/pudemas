<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pickup;
use App\Delivery;
use App\User;
use Auth;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data['title']          	= 'Dashboard - PUDEMAS';
		$data['page']           	= 'Dashboard';
		$data['job_pickup']     	= Pickup::PickupCourierHome(Auth::id())->get();
		$data['free_courier']		= User::Courier()->where('is_free', '1')->count();
		$data['all_courier']		= User::Courier()->count();
		$data['active_pickup']		= Pickup::PickupActiveHome()->count();
		$data['active_delivery']	= Delivery::DeliveryActiveHome()->count();
		$data['pickup_count']		= Pickup::CountAllPickup()->groupBy('pick_up.courier')->get();
		$data['delivery_count']		= Delivery::CountAllDelivery()->groupBy('delivery.courier')->get();

		return view('home')->with($data);
	}
}
