<?php

namespace App\Http\Controllers;

use App\Pickup;
use App\PickupDetail;
use App\Customer;
use App\Item;
use App\User;
use Illuminate\Http\Request;
use DB;
use Validator;
use DataTables;
use Telegram;
use Carbon\Carbon;
use Auth;

class PickupController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function pickupActive()
	{
		$data['title']			= 'Data Pickup Active - PUDEMAS';
		$data['page']			= 'Data Pickup Active';

		return view('pickup/active')->with($data);
	}

	public function pickupActiveCourier()
	{
		$data['title']			= 'Data Pickup Active - PUDEMAS';
		$data['page']			= 'Data Pickup Active';

		return view('pickup/active_courier')->with($data);
	}

	public function getPickupActive()
	{
		try {

			$active 	= Pickup::select([
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
			->where('pick_up.status', '!=', '0')
			->orderBy('pick_up.created_at', 'DESC')
			->orderBy('pick_up_detail.is_first_row', 'DESC')
			->get();

			return Datatables::of($active)
			->editColumn('id_pickup', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->id_pickup;
				}else {
					return ' ';
				}
			})
			->editColumn('status', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->status == 3) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
						</div><hr>Job Disampaikan Ke Kurir';	
					}elseif($active->status == 2) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
						</div><hr>Job diterima Kurir, dan sedang dilakukan pengambilan';	
					}elseif($active->status == 1) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
						</div><hr>Kurir selesai mengambil barang di supplier, dan perjalanan kembali ke toko atau ke customer';	
					}else {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
						</div><hr>Job telah selesai';	
					}
				}else {
					return ' ';
				}
			})
			->editColumn('courier_name', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->courier_name;
				}else {
					return ' ';
				}
			})
			->editColumn('type', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->type;
				}else {
					return ' ';
				}
			})
			->editColumn('is_send_to_customer', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->is_send_to_customer == 1) {
						$is_send 	= 'Ya';
					}else {
						$is_send = 'Tidak';
					}
					return $is_send;
				}else {
					return ' ';
				}
			})

			->editColumn('purchase_price', function ($active) {
				return 'Rp. '.number_format($active->purchase_price);
			})
			
			->addColumn('action', function ($active) {
				if ($active->is_first_row == 1) {
					return '
					<a href="'.url('pickup/getPickupActiveById/'.$active->id_pickup).'" class="btn btn-info btn-sm mr-1 mb-2"><i class="la la-edit edit"></i></a>
					<button type="button" id="'.$active->id_pickup.'" class="btn btn-danger btn-sm mr-1 mb-2 button-destroy"><i class="la la-close delete"></i></button>';
				}else {
					return ' ';
				}
			})
			->rawColumns(['status', 'action'])
			->make(true);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
	}

	public function getPickupActiveCourier()
	{
		$user                   = Auth::user();
		try {

			$active 	= Pickup::select([
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
			->where('pick_up.status', '!=', '0')
			->orderBy('pick_up.created_at', 'DESC')
			->orderBy('pick_up_detail.is_first_row', 'DESC')
			->get();

			return Datatables::of($active)
			->editColumn('id_pickup', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->id_pickup;
				}else {
					return ' ';
				}
			})
			->editColumn('status', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->status == 3) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
						</div><hr>Job Disampaikan Ke Kurir';	
					}elseif($active->status == 2) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
						</div><hr>Job diterima Kurir, dan sedang dilakukan pengambilan';	
					}elseif($active->status == 1) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
						</div><hr>Kurir selesai mengambil barang di supplier, dan perjalanan kembali ke toko atau ke customer';	
					}else {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
						</div><hr>Job telah selesai';	
					}
				}else {
					return ' ';
				}
			})
			->editColumn('courier_name', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->courier_name;
				}else {
					return ' ';
				}
			})
			->editColumn('type', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->type;
				}else {
					return ' ';
				}
			})
			->editColumn('is_send_to_customer', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->is_send_to_customer == 1) {
						$is_send 	= 'Ya';
					}else {
						$is_send = 'Tidak';
					}
					return $is_send;
				}else {
					return ' ';
				}
			})

			->editColumn('purchase_price', function ($active) {
				return 'Rp. '.number_format($active->purchase_price);
			})
			
			->addColumn('action', function ($active) {
				if ($active->is_first_row == 1) {
					return '
					<a href="'.url('pickup/getPickupActiveById/'.$active->id_pickup).'" class="btn btn-info btn-sm mr-1 mb-2"><i class="la la-edit edit"></i></a>
					<button type="button" id="'.$active->id_pickup.'" class="btn btn-danger btn-sm mr-1 mb-2 button-destroy"><i class="la la-close delete"></i></button>';
				}else {
					return ' ';
				}
			})
			->rawColumns(['status', 'action'])
			->make(true);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
	}

	public function getPickupActiveById($id_pickup)
	{
		try {
			$pickup 		= Pickup::select([
				'pick_up.id as id_pickup',
				'users.name as courier_name',
				'pick_up.type',
				'pick_up.is_send_to_customer',
				'pick_up.status',
				'supplier.name as supplier_name',
				'item.name as item_name',
				'pick_up_detail.qty',
				'pick_up_detail.purchase_price',
			])
			->join('pick_up_detail', 'pick_up_detail.pick_up_id', '=', 'pick_up.id')
			->join('supplier', 'supplier.id', '=', 'pick_up_detail.supplier')
			->join('item', 'item.id', '=', 'pick_up_detail.item')
			->join('users', 'users.id', '=', 'pick_up.courier')
			->where('pick_up.id', $id_pickup)
			->get();

			$data['title'] 			= 'Detail Pengambilan ID Pickup '.$id_pickup.' - PUDEMAS';
			$data['page'] 			= 'Detail Pengambilan ID Pickup '.$id_pickup;

			//Count transaction total
			$gt 		= 0;
			foreach($pickup as $i) {
				$tot 	= $i['qty']*$i['purchase_price'];
				$gt 	= $tot+$gt;
			}

			//determine status 
			if ($pickup[0]->status == '3') {
				$status 		= '<div class="progress progress-lg mb-3">
				<div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
				</div><hr>Job Disampaikan Ke Kurir';
			} elseif($pickup[0]->status == '2') {
				$status 		= '<div class="progress progress-lg mb-3">
				<div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
				</div><hr>Job diterima Kurir, dan sedang dilakukan pengambilan';	
			}elseif($pickup[0]->status == '1') {
				$status 		= '<div class="progress progress-lg mb-3">
				<div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
				</div><hr>Kurir selesai mengambil barang di supplier, dan perjalanan kembali ke toko atau ke customer';	
			}elseif($pickup[0]->status == '0') {
				$status 		= '<div class="progress progress-lg mb-3">
				<div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
				</div><hr>Job telah selesai';
			}

			//determine send type
			if ($pickup[0]->is_send_to_customer == 0) {
				$send 				= 'Tidak';
			}else {
				$send 				= 'Ya';
			}

			return view('pickup/detail', compact('pickup', 'gt', 'status', 'send'))->with($data);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$title          = 'Add Pengambilan - PUDEMAS';
		$page           = 'Add Pengambilan';
		return view('pickup/create', compact('title','page'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storePickup(Request $request)
	{
		$is_send 			= $request->is_send_to_customer;
		$id_courier 		= $request->courier;

		// ID Pickup
		if ($is_send == '0') {
			$cd 	= 'PU';
		}elseif ($is_send == '1')
		{
			$cd 	= 'PD';
		}
		$id_pickup 			= $cd.Carbon::now()->format('ymdHis');

		// Find Courier 
		$courier 			= User::find($id_courier);
		$nm_courier 		= $courier->name;

		// Jika data item diambil kosong
		if (empty(session('item-pickup'))) {
			return redirect()->route('createPickup')
			->with('error', 'Data Item Yang Diambil Kosong, Silahkan Isi Terlebih Dulu Lalu Submit Data Sekali Lagi.');
		}

		try {
			// Jika tidak langsung dikirim ke customer
			if ($is_send == '0') {
				$attributeNames 		= array(
					'courier'				=> 'Kurir',
					'type'					=> 'Type Pembelian',
				);

				$validator 				= Validator::make($request->all(), [
					'courier'				=> 'required',
					'type'					=> 'required',
				]);

				$validator->setAttributeNames($attributeNames);

				if ($validator->fails()) {
					return redirect()->route('createPickup')
					->withErrors($validator)
					->withInput();
				}

				$pickup 						= new Pickup();
				$pickup->id 					= $id_pickup;
				$pickup->courier 				= $id_courier;
				$pickup->type 					= $request->type;
				$pickup->is_send_to_customer	= $is_send;
				$pickup->save();

				// Save Detail Pickup
				$row_identifier = 0;
				foreach (session('item-pickup') as $i) {
					if ($row_identifier == 0) {
						$row 			= 1;
					}else {
						$row 			= 0;
					}

					$detail 					= new PickupDetail();
					$detail->pick_up_id 		= $id_pickup;
					$detail->supplier 			= $i['id_supplier'];
					$detail->item 				= $i['id_item'];
					$detail->qty 				= $i['qty'];
					$detail->purchase_price 	= $i['purchase_price'];
					$detail->is_first_row 		= $row;
					$detail->save();
					$row_identifier 			= 1;
				}

				// Hapus session item pickup
				$request->session()->forget('item-pickup');

				// Send Telegram Message
				$text = "<code>Job Baru Pengambilan Barang</code>\n"
				. "\n"
				. "Hello Kurir,<b> ".$nm_courier.". </b>\n"
				. "Anda telah mendapatkan Job baru untuk melakukan pengambilan barang.\n"
				. "Silahkan ambil Job berikut dengan mengklik tautan dibawah.\n"
				. "\n"
				. "<a href='".url('/pickup/getPickupActiveById/'.$id_pickup)."'>Ambil Job</a>";

				$send = Telegram::sendMessage([
					'chat_id' => env('TELEGRAM_GROUP_TOKEN', 'YOUR-GROUP-TOKEN'),
					'parse_mode' => 'HTML',
					'text' => $text
				]);

				return redirect()->route('createPickup')
				->with('success', 'Data Berhasil Disimpan');
			}
			
		} catch (\Exception $e) {
			return redirect()->route('createPickup')
			->with('error', $e->getMessage());
		}
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Pickup  $pickup
	 * @return \Illuminate\Http\Response
	 */
	public function show(Pickup $pickup)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Pickup  $pickup
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Pickup $pickup)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Pickup  $pickup
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Pickup $pickup)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Pickup  $pickup
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Pickup $pickup)
	{
		//
	}

	/**
	*Utilities Function
	*
	*/
	public function acceptPickupJob(Request $request)
	{
		try {
			$user 			= Auth::user();
			if ($request->is_send_to_customer == 0) {
				$pickup 		= Pickup::find($request->id_pickup);
				$pickup->status = '2';
				$pickup->save();

				$courier 			= User::find($user->id);
				$courier->is_free 	= '0';
				$courier->save();
			}

			return back()->with('success', 'Job berhasil diterima');
			
		} catch (\Exception $e) {
			return back()->with('error',$e->getMessage());
		}
	}

	 /**
	 * Telegram Function
	 *
	 * @param  \App\Pickup  $pickup
	 * @return \Illuminate\Http\Response
	 */
	 public function updatedActivity(Request $request)
	 {
	 	$activity = Telegram::getUpdates();
	 	dd($activity);
	 }
}
