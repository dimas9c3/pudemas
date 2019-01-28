<?php

namespace App\Http\Controllers;

use App\Delivery;
use App\DeliveryDetail;
use App\Pickup;
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
use Image;
use Storage;

class DeliveryController extends Controller
{
	protected $DeliveryModel;

	function __construct()
	{
		$this->DeliveryModel          = new Delivery();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data['title']          = 'Data Pengiriman Selesai - PUDEMAS';
		$data['page']           = 'Data Pengiriman Selesai';

		return view('delivery/index')->with($data);
	}

	public function activeDelivery()
	{
		$data['title']          = 'Data Pengiriman Aktif - PUDEMAS';
		$data['page']           = 'Data Pengiriman Aktif';

		return view('delivery/active')->with($data);
	}

	public function activeDeliveryCourier()
	{
		$data['title']          = 'Data Pengiriman Aktif - PUDEMAS';
		$data['page']           = 'Data Pengiriman Aktif';

		return view('delivery/active_courier')->with($data);
	}
	public function deliveryCancel()
	{
		$data['title']			= 'Data Pengiriman Dibatalkan - PUDEMAS';
		$data['page']			= 'Data Pengiriman Dibatalkan';

		return view('delivery/cancel')->with($data);
	}

	public function getDelivery()
	{
		try {
			$active             = $this->DeliveryModel->getDelivery();

			return Datatables::of($active)
			->editColumn('id_delivery', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->id_delivery;
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
					if ($active->status == 4) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
						</div><hr>Job Disampaikan Ke Kurir';    
					}elseif ($active->status == 3) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
						</div><hr>Job diterima, dan sedang dilakukan pengambilan ke supplier.';    
					}elseif($active->status == 2) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
						</div><hr>Kurir selesai mengambil barang di supplier.';    
					}elseif($active->status == 1) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
						</div><hr>Kurir sedang mengirim barang ke customer.'; 
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
			->editColumn('customer_name', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->customer_name;
				}else {
					return ' ';
				}
			})
			->editColumn('is_pickup_first', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->is_pickup_first == 1) {
						$is_pickup_first    = 'Ya';
					}else {
						$is_pickup_first = 'Tidak';
					}
					return $is_pickup_first;
				}else {
					return ' ';
				}
			})

			->editColumn('send_cost', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->send_cost) {
						$send_cost    = $active->send_cost;
					}else {
						$send_cost = 0;
					}
					return 'Rp. '.number_format($send_cost);
				}else {
					return ' ';
				}
			})

			->editColumn('selling_price', function ($active) {
				return 'Rp. '.number_format($active->selling_price);
			})
			
			->addColumn('action', function ($active) {
				if ($active->is_first_row == 1) {
					return '
					<a href="'.url('delivery/getDeliveryActiveById/'.$active->id_delivery).'" class="btn btn-info btn-sm mr-1 mb-2"><i class="la la-search detail"></i></a>';
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

	public function getDeliveryActive()
	{
		try {
			$active             = $this->DeliveryModel->getDeliveryActive();

			return Datatables::of($active)
			->editColumn('id_delivery', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->id_delivery;
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
					if ($active->status == 4) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
						</div><hr>Job Disampaikan Ke Kurir';    
					}elseif ($active->status == 3) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
						</div><hr>Job diterima, dan sedang dilakukan pengambilan ke supplier.';    
					}elseif($active->status == 2) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
						</div><hr>Kurir selesai mengambil barang di supplier.';    
					}elseif($active->status == 1) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
						</div><hr>Kurir sedang mengirim barang ke customer.'; 
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
			->editColumn('customer_name', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->customer_name;
				}else {
					return ' ';
				}
			})
			->editColumn('is_pickup_first', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->is_pickup_first == 1) {
						$is_pickup_first    = 'Ya';
					}else {
						$is_pickup_first = 'Tidak';
					}
					return $is_pickup_first;
				}else {
					return ' ';
				}
			})

			->editColumn('send_cost', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->send_cost) {
						$send_cost    = $active->send_cost;
					}else {
						$send_cost = 0;
					}
					return 'Rp. '.number_format($send_cost);
				}else {
					return ' ';
				}
			})

			->editColumn('selling_price', function ($active) {
				return 'Rp. '.number_format($active->selling_price);
			})
			
			->addColumn('action', function ($active) {
				if ($active->is_first_row == 1) {
					return '
					<a href="'.url('delivery/getDeliveryActiveById/'.$active->id_delivery).'" class="btn btn-info btn-sm mr-1 mb-2"><i class="la la-search detail"></i></a>
					<a href="'.route('cancelDelivery', ['id_delivery' => $active->id_delivery, 'id_courier' => $active->id_courier, 'is_pickup_first' => $active->is_pickup_first]).'" class="btn btn-danger btn-sm mr-1 mb-2"><i class="la la-close cancel"></i></a>';
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

	public function getDeliveryActiveCourier()
	{
		$user                   = Auth::user();
		try {
			$active             = $this->DeliveryModel->getDeliveryActiveCourier($user);

			return Datatables::of($active)
			->editColumn('id_delivery', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->id_delivery;
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
					if ($active->status == 4) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
						</div><hr>Job Disampaikan Ke Kurir';    
					}elseif ($active->status == 3) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
						</div><hr>Job diterima, dan sedang dilakukan pengambilan ke supplier.';    
					}elseif($active->status == 2) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
						</div><hr>Kurir selesai mengambil barang di supplier.';    
					}elseif($active->status == 1) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
						</div><hr>Kurir sedang mengirim barang ke customer.'; 
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
			->editColumn('customer_name', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->customer_name;
				}else {
					return ' ';
				}
			})
			->editColumn('is_pickup_first', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->is_pickup_first == 1) {
						$is_pickup_first    = 'Ya';
					}else {
						$is_pickup_first = 'Tidak';
					}
					return $is_pickup_first;
				}else {
					return ' ';
				}
			})

			->editColumn('send_cost', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->send_cost) {
						$send_cost    = $active->send_cost;
					}else {
						$send_cost = 0;
					}
					return 'Rp. '.number_format($send_cost);
				}else {
					return ' ';
				}
			})

			->editColumn('selling_price', function ($active) {
				return 'Rp. '.number_format($active->selling_price);
			})
			
			->addColumn('action', function ($active) {
				if ($active->is_first_row == 1) {
					return '
					<a href="'.url('delivery/getDeliveryActiveById/'.$active->id_delivery).'" class="btn btn-info btn-sm mr-1 mb-2"><i class="la la-search detail"></i></a>';
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

	public function getDeliveryCancel()
	{
		try {
			$active             = $this->DeliveryModel->getDeliveryCancel();

			return Datatables::of($active)
			->editColumn('id_delivery', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->id_delivery;
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
					}elseif ($active->status == 4) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
						</div><hr>Job Disampaikan Ke Kurir';    
					}elseif ($active->status == 3) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
						</div><hr>Job diterima, dan sedang dilakukan pengambilan ke supplier.';    
					}elseif($active->status == 2) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
						</div><hr>Kurir selesai mengambil barang di supplier.';    
					}elseif($active->status == 1) {
						return '<div class="progress progress-lg mb-3">
						<div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
						</div><hr>Kurir sedang mengirim barang ke customer.'; 
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
			->editColumn('customer_name', function ($active) {
				if ($active->is_first_row == 1) {
					return $active->customer_name;
				}else {
					return ' ';
				}
			})
			->editColumn('is_pickup_first', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->is_pickup_first == 1) {
						$is_pickup_first    = 'Ya';
					}else {
						$is_pickup_first = 'Tidak';
					}
					return $is_pickup_first;
				}else {
					return ' ';
				}
			})

			->editColumn('send_cost', function ($active) {
				if ($active->is_first_row == 1) {
					if ($active->send_cost) {
						$send_cost    = $active->send_cost;
					}else {
						$send_cost = 0;
					}
					return 'Rp. '.number_format($send_cost);
				}else {
					return ' ';
				}
			})

			->editColumn('selling_price', function ($active) {
				return 'Rp. '.number_format($active->selling_price);
			})
			
			->addColumn('action', function ($active) {
				if ($active->is_first_row == 1) {
					return '
					<a href="'.route('recycleDelivery', ['id_delivery' => $active->id_delivery, 'id_courier' => $active->id_courier, 'is_pickup_first' => $active->is_pickup_first]).'" class="btn btn-info btn-sm mr-1 mb-2"><i class="la la-recycle"></i></a>';
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

	public function getDeliveryActiveById($id_delivery)
	{
		try {

			$data['title']          = 'Detail Pengiriman ID Delivery '.$id_delivery.' - PUDEMAS';
			$data['page']           = 'Detail Pengiriman ID Delivery '.$id_delivery;

			$delivery               = $this->DeliveryModel->getDeliveryActiveById($id_delivery);

			//Count transaction total
			$gt         = 0;
			foreach($delivery as $i) {
				$tot    = $i['qty']*$i['selling_price'];
				$gt     = $tot+$gt;
			}
			// Jika ongkir sudah ditentukan
			if($delivery[0]->send_cost != NULL) {
				$send_cost  = $delivery[0]->send_cost;
				$gt         = $gt+$send_cost;
			}else {
				$send_cost  = 0;
			}

			//determine status 
			if ($delivery[0]->cancel != NULL) {
				$status         = '<div class="progress progress-lg mb-3">
				<div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Cancel</div>
				</div><hr>Job telah dibatalkan';
			} elseif ($delivery[0]->status == '4') {
				$status         = '<div class="progress progress-lg mb-3">
				<div class="progress-bar bg-primary" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
				</div><hr>Job Disampaikan Ke Kurir';
			} elseif($delivery[0]->status == '3') {
				$status         = '<div class="progress progress-lg mb-3">
				<div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
				</div><hr>Job diterima Kurir, dan sedang dilakukan pengambilan';    
			}elseif($delivery[0]->status == '2') {
				$status         = '<div class="progress progress-lg mb-3">
				<div class="progress-bar bg-primary" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
				</div><hr>Kurir selesai mengambil barang di supplier'; 
			}elseif($delivery[0]->status == '1') {
				$status         = '<div class="progress progress-lg mb-3">
				<div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
				</div><hr>Kurir sedang mengirim barang ke customer';
			}elseif($delivery[0]->status == '0') {
				$status         = '<div class="progress progress-lg mb-3">
				<div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
				</div><hr>Job telah selesai';
			}

			//determine send type
			if ($delivery[0]->is_pickup_first == 0) {
				$send               = 'Tidak';
			}else {
				$send               = 'Ya';
			}

			//phone for chatting
			$ph 					= substr($delivery[0]->phone, 1);
			$phone 					= '62'.$ph;

			return view('delivery/detail', compact('delivery', 'gt', 'status', 'send', 'send_cost', 'phone'))->with($data);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function createDelivery()
	{
		$data['title']          = 'Add Pengiriman - PUDEMAS';
		$data['page']           = 'Add Pengiriman';

		return view('delivery/create')->with($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeDelivery(Request $request)
	{
		$id_courier         = $request->courier;
		$cd                 = 'DL';

		$id_delivery        = $cd.Carbon::now()->format('ymdHis');

		// Find Courier 
		$courier            = User::find($id_courier);
		$nm_courier         = $courier->name;

		// Jika data item dikirim kosong
		if (empty(session('item-delivery'))) {
			return back()
			->with('error', 'Data Item Yang Dikirim Kosong, Silahkan Isi Terlebih Dulu Lalu Submit Data Sekali Lagi.');
		}

		try {
			$attributeNames         = array(
				'courier'               => 'Kurir',
				'customer'              => 'Customer',
				'send_cost'             => 'Ongkos Pengiriman',
			);

			$validator              = Validator::make($request->all(), [
				'courier'               => 'required',
				'customer'              => 'required',
			]);

			$validator->setAttributeNames($attributeNames);

			if ($validator->fails()) {
				return redirect()->back()
				->withErrors($validator)
				->withInput();
			}

			// Save Delivery
			$delivery                       = new Delivery();
			$delivery->id                   = $id_delivery;
			$delivery->customer             = $request->customer;
			$delivery->courier              = $id_courier;
			$delivery->is_pickup_first      = '0';
			$delivery->send_cost            = $request->send_cost;
			$delivery->save();

			// Save Detail delivery
			$row_identifier = 0;
			foreach (session('item-delivery') as $i) {
				if ($row_identifier == 0) {
					$row            = 1;
				}else {
					$row            = 0;
				}

				$detail                     = new DeliveryDetail();
				$detail->delivery_id        = $id_delivery;
				$detail->item               = $i['id_item'];
				$detail->qty                = $i['qty'];
				$detail->selling_price      = $i['selling_price'];
				$detail->is_first_row       = $row;
				$detail->save();
				$row_identifier             = 1;
			}

			// Hapus session item delivery
			$request->session()->forget('item-delivery');

			// Send Telegram Message
			$text = "<code>Job Baru Pengambilan Barang</code>\n"
			. "\n"
			. "Hello Kurir,<b> ".$nm_courier.". </b>\n"
			. "Anda telah mendapatkan Job baru untuk melakukan pengiriman barang.\n"
			. "Silahkan ambil Job berikut dengan mengklik tautan dibawah.\n"
			. "\n"
			. "<a href='".route('activeDeliveryCourier')."'>Ambil Job</a>";

			$send = Telegram::sendMessage([
				'chat_id' => env('TELEGRAM_GROUP_TOKEN', 'YOUR-GROUP-TOKEN'),
				'parse_mode' => 'HTML',
				'text' => $text
			]);

			return redirect()->back()
			->with('success', 'Data Berhasil Disimpan');

		} catch (\Exception $e) {
			return redirect()->back()
			->with('error', $e->getMessage());
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Delivery  $delivery
	 * @return \Illuminate\Http\Response
	 */
	public function show(Delivery $delivery)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Delivery  $delivery
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Delivery $delivery)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Delivery  $delivery
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Delivery $delivery)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Delivery  $delivery
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Delivery $delivery)
	{
		//
	}

	/**
	*
	* Utilities Function
	*
	*/
	public function cancelDelivery(Request $request)
	{
		try {
			if ($request->is_pickup_first == 0) {
				$delivery 		= Delivery::where('id', $request->id_delivery);
				$delivery->Delete();

				$detail 		= DeliveryDetail::where('delivery_id', $request->id_delivery);
				$detail->delete();

				$courier 			= User::find($request->id_courier);
				$courier->is_free 	= '1';
				$courier->save();
			/*
			*
			IF PICKUP TO SUPPLIER
			*/
			}elseif($request->is_pickup_first == 1) {
				$pickup 		= Pickup::where('id', $request->id_delivery);
				$pickup->Delete();

				$detail 		= PickupDetail::where('pick_up_id', $request->id_delivery);
				$detail->delete();

				$delivery 		= Delivery::where('id', $request->id_delivery);
				$delivery->Delete();

				$detail 		= DeliveryDetail::where('delivery_id', $request->id_delivery);
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

	public function recycleDelivery(Request $request)
	{
		try {
			if ($request->is_pickup_first == 0) {
				$delivery 		= Delivery::where('id', $request->id_delivery);
				$delivery->restore();

				$detail 		= DeliveryDetail::where('delivery_id', $request->id_delivery);
				$detail->restore();

				$courier 			= User::find($request->id_courier);
				$courier->is_free 	= '0';
				$courier->save();
			/*
			*
			IF PICKUP TO SUPPLIER
			*/
			}elseif($request->is_pickup_first == 1) {
				$pickup 		= Pickup::where('id', $request->id_delivery);
				$pickup->restore();

				$detail 		= PickupDetail::where('pick_up_id', $request->id_delivery);
				$detail->restore();

				$delivery 		= Delivery::where('id', $request->id_delivery);
				$delivery->restore();

				$detail 		= DeliveryDetail::where('delivery_id', $request->id_delivery);
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

	public function changeDeliveryJob(Request $request)
	{
		try {
			$user           = Auth::user();
			//Jika diambil ke supplier
			if ($request->is_pickup_first == 1) {

				$pickup         = Pickup::find($request->id_delivery);
				$pickup->status = $request->changeTo-1;
				$pickup->save();

				$delivery           = Delivery::find($request->id_delivery);
				$delivery->status   = $request->changeTo;
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

	public function finishDelivery(Request $request)
	{
		try {
			$user           = Auth::user();
			//Jika diambil ke supplier
			if ($request->is_pickup_first == 1) {

				$attributeNames             = array(
					'reciver'               => 'Penerima',
					'received_proof'        => 'Bukti Penerimaan'
				);

				$validator                  = Validator::make($request->all(), [
					'receiver'              => 'required|min:2',
					'received_proof'        => 'image|mimes:jpeg,bmp,png,jpg',
				]);

				$validator->setAttributeNames($attributeNames);

				if ($validator->fails()) {
					return back()
					->withErrors($validator)
					->withInput();
				}

				$file = $request->file('received_proof');
				//get filename with extension
				$filenamewithextension = $file->getClientOriginalName();

				//get filename without extension
				$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

				//get file extension
				$extension = $file->getClientOriginalExtension();

				//filename to store
				$filenametostore = $filename.'_'.uniqid().'.'.$extension;

				//thumbnail path
				$thumbnailpath = public_path('storage/images/received_proof/thumbnail/'.$filenametostore);

				//Resize image here
				$image = Image::make($file->getRealPath());

				$image->fit(300, 300, function ($constraint) {
					$constraint->aspectRatio();
				})->save($thumbnailpath);

				// Store Original image size
				Storage::put('public/images/received_proof/'. $filenametostore, fopen($file, 'r+'));

				$delivery                   = Delivery::find($request->id_delivery);
				$delivery->status           = '0';
				$delivery->receiver         = $request->receiver;
				$delivery->received_proof   = $filenametostore;
				$delivery->save();

				$courier            = User::find($user->id);
				$courier->is_free   = '1';
				$courier->save();
				
			}

			return back()->with('success', 'Job berhasil diupdate');
			
		} catch (\Exception $e) {
			return back()->with('error',$e->getMessage());
		}
	}
}
