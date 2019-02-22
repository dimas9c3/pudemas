<?php

namespace App\Http\Controllers;

use App\Delivery;
use Illuminate\Http\Request;
use Validator;

class FrontController extends Controller
{
	public function index()
	{
		$delivery 			= NULL;
		return view('frontend.home', compact('delivery'));
	}

	public function about()
	{
		return view('frontend.about');
	}

	public function checkResi(Request $request)
	{
		
		$id_resi 				= $request->id_resi;

		$attributeNames 		= array(
			'id_resi'			=> 'Nomor Resi',
		);

		$validator 				= Validator::make($request->all(), [
			'id_resi'			=> 'required|min:14',
		]);

		$validator->setAttributeNames($attributeNames);

		if($validator->fails()) {
			return redirect()->back()
			->withErrors($validator)
			->withInput();
		}

		try {
			$data['delivery']         = Delivery::select([
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
			->where('delivery.id', $id_resi)
			->get();

			//Jika data ditemukan
			if($data['delivery'][0]->id_delivery) {
				return view('frontend.home')->with($data);
			}
		} catch (\Exception $e) {
			return redirect()->back()->with('error', 'Kami Tidak Menemukan Data Nomor Resi Anda');
		}
		
	}
}
