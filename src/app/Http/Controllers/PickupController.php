<?php

namespace App\Http\Controllers;

use App\Pickup;
use App\PickupDetail;
use App\Delivery;
use App\DeliveryDetail;
use App\Customer;
use App\Item;
use App\User;
use App\Setting;
use App\Mail\SellingInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;
use Validator;
use DataTables;
use Telegram;
use Carbon\Carbon;
use Auth;
use PDF;

class PickupController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index()
	{
		$data['title']			= 'Data Pickup Selesai - PUDEMAS';
		$data['page']			= 'Data Pickup Selesai';

		return view('pickup/index')->with($data);
	}

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

	public function pickupCancel()
	{
		$data['title']			= 'Data Pickup Dibatalkan - PUDEMAS';
		$data['page']			= 'Data Pickup Dibatalkan';

		return view('pickup/cancel')->with($data);
	}

	public function getPickup()
	{
		try {

			$active 			= Pickup::Pickup()
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
			->editColumn('date', function ($active) {
				if ($active->is_first_row == 1) {
					return Carbon::createFromFormat('Y-m-d H:i:s', $active->date)->format('d-m-Y');
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
					<a href="'.url('pickup/getPickupById/'.$active->id_pickup).'" class="btn btn-info btn-sm mr-1 mb-2"><i class="la la-search detail"></i></a>';
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

	public function getPickupActive()
	{
		try {

			$active 			= Pickup::PickupActive()
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
					<a href="'.url('pickup/getPickupById/'.$active->id_pickup).'" class="btn btn-info btn-sm mr-1 mb-2"><i class="la la-search detail"></i></a>
					<a href="'.route('cancelPickup', ['id_pickup' => $active->id_pickup, 'id_courier' => $active->id_courier, 'is_send_to_customer' => $active->is_send_to_customer]).'" class="btn btn-danger btn-sm mr-1 mb-2"><i class="la la-close cancel"></i></a>';
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

			$active 			= Pickup::PickupActiveCourier($user)
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
					<a href="'.url('pickup/getPickupById/'.$active->id_pickup).'" class="btn btn-info btn-sm mr-1 mb-2"><i class="la la-search detail"></i></a>';
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

	public function getPickupCancel()
	{
		try {

			$active 			= Pickup::PickupCancel()
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
			->editColumn('date', function ($active) {
				if ($active->is_first_row == 1) {
					return Carbon::createFromFormat('Y-m-d H:i:s', $active->date)->format('d-m-Y');
				}else {
					return ' ';
				}
			})
			->editColumn('status', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->cancel != NULL) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Cancel</div>
						</div><hr>Job Dibatalkan';	
					}elseif ($active->status == 3) {
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
					<a href="'.route('recyclePickup', ['id_pickup' => $active->id_pickup, 'id_courier' => $active->id_courier, 'is_send_to_customer' => $active->is_send_to_customer]).'" class="btn btn-info btn-sm mr-1 mb-2"><i class="la la-recycle"></i></a>';
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

	public function getPickupById($id_pickup)
	{
		try {

			//Jika data yang dicari tidak ada
			$pickup 				= Pickup::PickupById($id_pickup)->count();

			if($pickup < 1) {
				return redirect()->back()->with('error', 'Data Yang Dicari Tidak ada..');
			}

			$setting 				= Setting::find(1);
			$watcher 				= $setting->watcher_view_update;
			$courier_update 		= $setting->courier_location_update;
			$pickup 				= Pickup::PickupById($id_pickup)->get();

			$data['title'] 			= 'Detail Pengambilan ID Pickup '.$id_pickup.' - PUDEMAS';
			$data['page'] 			= 'Detail Pengambilan ID Pickup '.$id_pickup;

			//Count transaction total
			$gt 		= 0;
			foreach($pickup as $i) {
				$tot 	= $i['qty']*$i['purchase_price'];
				$gt 	= $tot+$gt;
			}

			//determine status 
			if ($pickup[0]->cancel != NULL) {
				$status 		= '<div class="progress progress-lg mb-3">
				<div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Cancel</div>
				</div><hr>Job telah dibatalkan';
			} elseif ($pickup[0]->status == '3') {
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

			return view('pickup/detail', compact('pickup', 'gt', 'status', 'send', 'watcher', 'courier_update'))->with($data);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
	}
	
	public function getPickupLocation(Request $request)
	{
		$pickup             = Pickup::select([
			'latitude',    
			'longtitude'
		])
		->where('id', $request->id)
		->get();

		return response()->json($pickup);
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
				. "<a href='".url('/pickup/active')."'>Ambil Job</a>";

				$send = Telegram::sendMessage([
					'chat_id' => env('TELEGRAM_GROUP_TOKEN', 'YOUR-GROUP-TOKEN'),
					'parse_mode' => 'HTML',
					'text' => $text
				]);

				return redirect()->route('createPickup')
				->with('success', 'Data Berhasil Disimpan');
			/*
			*
			*
			END OF IF DIDN'T SEND TO CUSTOMER
			*
			*
			*/
			// Jika dikirim langsung ke customer
			}elseif($is_send == '1') {
					// Jika data item dikirim kosong
				if (empty(session('item-delivery'))) {
					return redirect()->route('createPickup')
					->with('error', 'Data Item Yang Dikirim Kosong, Silahkan Isi Terlebih Dulu Lalu Submit Data Sekali Lagi.');
				}

				$attributeNames 		= array(
					'courier'				=> 'Kurir',
					'type'					=> 'Type Pembelian',
					'customer'				=> 'Customer',
					'send_cost'				=> 'Ongkos Pengiriman',
				);

				$validator 				= Validator::make($request->all(), [
					'courier'				=> 'required',
					'customer'				=> 'required',
					'type'					=> 'required',
				]);

				$validator->setAttributeNames($attributeNames);

				if ($validator->fails()) {
					return redirect()->route('createPickup')
					->withErrors($validator)
					->withInput();
				}

				// Save Pickup
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

				// Save Delivery
				$delivery 						= new Delivery();
				$delivery->id 					= $id_pickup;
				$delivery->customer 			= $request->customer;
				$delivery->courier 				= $id_courier;
				$delivery->is_pickup_first 		= $is_send;
				$delivery->send_cost 			= $request->send_cost;
				$delivery->save();

				// Save Detail delivery
				$row_identifier = 0;
				foreach (session('item-delivery') as $i) {
					if ($row_identifier == 0) {
						$row 			= 1;
					}else {
						$row 			= 0;
					}

					$detail 					= new DeliveryDetail();
					$detail->delivery_id 		= $id_pickup;
					$detail->item 				= $i['id_item'];
					$detail->qty 				= $i['qty'];
					$detail->selling_price 		= $i['selling_price'];
					$detail->is_first_row 		= $row;
					$detail->save();
					$row_identifier 			= 1;
				}

				//Send Email

				$cust 			= Customer::find($request->customer);

				$content = [
		 			'title'				=> 'PUDEMAS SHOP', 
		 			'body'				=> 'Terima Kasih Telah Berbelanja.',
		 			'button' 			=> 'Click Here',
		 			'url'				=> url('/'),
		 			'id_delivery'		=> $id_pickup,
	 			];

		 		Mail::to($cust->email)->send(new SellingInvoice($content));

				// Hapus session item pickup
				$request->session()->forget('item-pickup');
				$request->session()->forget('item-delivery');

					// Send Telegram Message
				$text = "<code>Job Baru Pengambilan Barang</code>\n"
				. "\n"
				. "Hello Kurir,<b> ".$nm_courier.". </b>\n"
				. "Anda telah mendapatkan Job baru untuk melakukan pengambilan barang.\n"
				. "Silahkan ambil Job berikut dengan mengklik tautan dibawah.\n"
				. "\n"
				. "<a href='".url('/pickup/active')."'>Ambil Job</a>";

				$send = Telegram::sendMessage([
					'chat_id' => env('TELEGRAM_GROUP_TOKEN', 'YOUR-GROUP-TOKEN'),
					'parse_mode' => 'HTML',
					'text' => $text
				]);

				return redirect()->route('createPickup')
				->with('success', 'Data Berhasil Disimpan');
			} 

		}catch (\Exception $e) {
			return redirect()->route('createPickup')
			->with('error', $e->getMessage());
		}
	}

	public function storeLocation(Request $request) 
	{
		try {
			
			// If Send To Customer
			if ($request->is_send_to_customer == 1) {
				$delivery 				= Delivery::find($request->id);
				$delivery->latitude 	= $request->latitude;
				$delivery->longtitude 	= $request->longtitude;
				$delivery->save();

				$pickup 				= Pickup::find($request->id);
				$pickup->latitude 		= $request->latitude;
				$pickup->longtitude 	= $request->longtitude;
				$ajax 					= $pickup->save();
			}else{
				$pickup 				= Pickup::find($request->id);
				$pickup->latitude 		= $request->latitude;
				$pickup->longtitude 	= $request->longtitude;
				$ajax 					= $pickup->save();
			}
			
			return response()->json($ajax);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
	}

	/**
	*Utilities Function
	*
	*/
	public function changePickupJob(Request $request)
	{
		try {
			$user 			= Auth::user();
			//Jika tidak dikirim langsung
			if ($request->is_send_to_customer == 0) {
				//jika job telah selesai
				if($request->changeTo == 0) {
					$pickup 		= Pickup::find($request->id_pickup);
					$pickup->status = $request->changeTo;
					$pickup->save();

					$courier 			= User::find($user->id);
					$courier->is_free 	= '1';
					$courier->save();
				}else {
					$pickup 		= Pickup::find($request->id_pickup);
					$pickup->status = $request->changeTo;
					$pickup->save();

					$courier 			= User::find($user->id);
					$courier->is_free 	= '0';
					$courier->save();
				}	
			/*
			*
			IF SEND TO CUSTOMER
			*/	
			}elseif($request->is_send_to_customer == 1) {
				$pickup         = Pickup::find($request->id_pickup);
				$pickup->status = $request->changeTo;
				$pickup->save();

				$delivery           = Delivery::find($request->id_pickup);
				$delivery->status   = $request->changeTo+1;
				$delivery->save();

				$courier            = User::find($user->id);
				$courier->is_free   = '0';
				$courier->save();
			}
			return back()->with('success', 'Job berhasil diupdate');
		} catch (\Exception $e) {
			return back()->with('error',$e->getMessage());
		}
	}

	public function cancelPickup(Request $request)
	{
		try {
			if ($request->is_send_to_customer == 0) {
				$pickup 		= Pickup::where('id', $request->id_pickup);
				$pickup->Delete();

				$detail 		= PickupDetail::where('pick_up_id', $request->id_pickup);
				$detail->delete();

				$courier 			= User::find($request->id_courier);
				$courier->is_free 	= '1';
				$courier->save();
			/*
			*
			IF SEND TO CUSTOMER
			*/
			}elseif($request->is_send_to_customer == 1) {
				$pickup 		= Pickup::where('id', $request->id_pickup);
				$pickup->Delete();

				$detail 		= PickupDetail::where('pick_up_id', $request->id_pickup);
				$detail->delete();

				$delivery 		= Delivery::where('id', $request->id_pickup);
				$delivery->Delete();

				$detail 		= DeliveryDetail::where('delivery_id', $request->id_pickup);
				$detail->delete();

				$courier 			= User::find($request->id_courier);
				$courier->is_free 	= '1';
				$courier->save();
			}

			return back()->with('success', 'Job berhasil dibatalkan');
		} catch (\Exception $e) {
			return back()->with('error', $e->getMessage());
		}
	}

	public function recyclePickup(Request $request)
	{
		try {
			if ($request->is_send_to_customer == 0) {
				$pickup 		= Pickup::where('id', $request->id_pickup);
				$pickup->restore();

				$detail 		= PickupDetail::where('pick_up_id', $request->id_pickup);
				$detail->restore();

				$courier 			= User::find($request->id_courier);
				$courier->is_free 	= '0';
				$courier->save();
				/*
				*
				IF SEND TO CUSTOMER
				*/
			}elseif($request->is_send_to_customer == 1) {
				$pickup 		= Pickup::where('id', $request->id_pickup);
				$pickup->restore();

				$detail 		= PickupDetail::where('pick_up_id', $request->id_pickup);
				$detail->restore();

				$delivery 		= Delivery::where('id', $request->id_pickup);
				$delivery->restore();

				$detail 		= DeliveryDetail::where('delivery_id', $request->id_pickup);
				$detail->restore();

				$courier 			= User::find($request->id_courier);
				$courier->is_free 	= '0';
				$courier->save();
			}

			return back()->with('success', 'Job berhasil diupdate');
		} catch (\Exception $e) {
			return back()->with('error', $e->getMessage());
		}
	}

	/**
	* 
	*Telegram Function
	*
	*/

	public function updatedActivity(Request $request)
	{
		$activity = Telegram::getUpdates();
		dd($activity);
	}

	/* Report */

	public function reportPickup(Request $request)
	{
		$start_date 		= $request->start_date;
		$end_date 			= $request->end_date;

		$pickup 			= Pickup::Pickup()
			->where('pick_up.created_at', '>=', Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d'))
			->where('pick_up.created_at', '<=', Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d'))
			->orderBy('pick_up.created_at', 'DESC')
			->orderBy('pick_up_detail.is_first_row', 'DESC')
			->get();

		$pdf = PDF::loadView('report.pickup', compact('pickup', 'start_date', 'end_date'));

        return $pdf->stream('pickup-report-'.$start_date.'-'.$end_date);
	}

	public function notePickup($id_pickup)
	{
		$pickup 			= Pickup::PickupById($id_pickup)
			->orderBy('pick_up.created_at', 'DESC')
			->orderBy('pick_up_detail.is_first_row', 'DESC')
			->get();

		$pdf = PDF::loadView('report.pickup_note', compact('pickup'));

        return $pdf->stream('pickup_note-report-'.Carbon::now());
	}
}