<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Validator;
use PDF;
use Carbon\Carbon;

class CustomerController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	function __construct()
	{
		$this->middleware('permission:master-customers');
	}

	public function index()
	{
		$data['title']          = 'Data Customer - PUDEMAS';
		$data['page']           = 'Data Customer';
		return view('customer')->with($data);
	}

	public function getCustomer()
	{
		try {
			$customer           = Customer::Customer()
			->orderBy('customer.name','asc')
			->get();

			return Datatables::of($customer)
			->addColumn('action', function ($customer) {
				return '
				<button type="button" id="'.$customer->id.'" class="btn btn-info btn-sm mr-1 mb-2 button-update"><i class="la la-edit edit"></i></button>
				<button type="button" id="'.$customer->id.'" class="btn btn-danger btn-sm mr-1 mb-2 button-destroy"><i class="la la-close delete"></i></button>';
			})
			->make(true);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}  
	}

	public function getCustomerById(Request $request)
	{
		try {
			$customer           = Customer::select([
				'customer.id',
				'customer.name',
				'customer_type.id as type_id',
				'customer_type.name as type',
				'customer.email',
				'customer.phone',
				'customer.address'
			])
			->join('customer_type', 'customer_type.id', '=', 'customer.customer_type')
			->where('customer.id', $request->id)
			->get();

			return response()->json($customer);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}

	}

	public function getCustomerType()
	{
		try {
			DB::statement(DB::raw('set @rownum=0'));

			$customerType   = CustomerType::select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'id',
				'name',
			])
			->orderBy('name','asc')
			->get();

			return Datatables::of($customerType)
			->addColumn('action', function ($customerType) {
				return '
				<button type="button" id="'.$customerType->id.'" name="'.$customerType->name.'" class="btn btn-info btn-sm mr-1 mb-2 button-update"><i class="la la-edit edit"></i></button>
				<button type="button" id="'.$customerType->id.'" class="btn btn-danger btn-sm mr-1 mb-2 button-destroy"><i class="la la-close delete"></i></button>';
			})
			->make(true);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}  
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function storeCustomer(Request $request)
	{
		try {
			$validator = Validator::make($request->all(),[
				'name' => 'required|min:3',
				'type' => 'required',
				'email' => 'required|email',
				'phone' => 'required|regex:/(08)[0-9]{9}/|max:13|min:11',
				'address' => 'required|min:3',
			]);

			if ($validator->fails()) {
				return redirect()->route('customer')
				->withErrors($validator)
				->withInput();
			}

			$customer                   = new Customer;
			$customer->customer_type    = $request->type;
			$customer->name             = $request->name;
			$customer->email            = $request->email;
			$customer->phone            = $request->phone;
			$customer->address          = $request->address;
			$customer->save();

			return redirect()->route('customer')
			->with('success','Data Customer Berhasil Disimpan.');
		}catch (\Exception $e) {
			return redirect()->route('customer')
			->with('error',$e->getMessage());
		}
		
	}

	public function storeCustomerType(Request $request)
	{
		try {
			$validator = Validator::make($request->all(),[
				'name' => 'required|min:4',
			]);

			if ($validator->fails()) {
				return redirect()->route('customer')
				->withErrors($validator)
				->withInput();
			}

			$crud               = new CustomerType;
			$crud->name         = $request->name;
			$crud->save();

			return redirect()->route('customer')
			->with('success','Data Jenis Customer Berhasil Disimpan.');
		}catch (\Exception $e) {
			return redirect()->route('customer')
			->with('error',$e->getMessage());
		}
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\CustomerType  $customerType
	 * @return \Illuminate\Http\Response
	 */

	public function updateCustomer(Request $request)
	{
		try {
			$validator = Validator::make($request->all(),[
				'name' => 'required|min:3',
				'type' => 'required',
				'email' => 'required|email',
				'phone' => 'required|regex:/(08)[0-9]{9}/|max:13|min:11',
				'address' => 'required|min:3',
			]);

			if ($validator->fails()) {
				return redirect()->route('customer')
				->withErrors($validator)
				->withInput();
			}

			$customer                   = Customer::find($request->id);
			$customer->name             = $request->name;
			$customer->customer_type    = $request->type;
			$customer->email            = $request->email;
			$customer->phone            = $request->phone;
			$customer->address          = $request->address;
			$customer->save();

			return redirect()->route('customer')
			->with('success','Data Berhasil Diubah');
		} catch (\Exception $e) {
			return redirect()->route('customer')
			->with('error',$e->getMessage());
		}
	}

	public function updateCustomerType(Request $request)
	{
		try {
			$validator = Validator::make($request->all(),[
				'name' => 'required|min:4',
			]);

			if ($validator->fails()) {
				return redirect()->route('customer')
				->withErrors($validator)
				->withInput();
			}

			$crud               = CustomerType::find($request->id);
			$crud->name         = $request->name;
			$crud->save();

			return redirect()->route('customer')
			->with('success','Data Berhasil Diubah');
		} catch (\Exception $e) {
			return redirect()->route('customer')
			->with('error',$e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\CustomerType  $customerType
	 * @return \Illuminate\Http\Response
	 */

	public function destroyCustomer(Request $request)
	{
		try {
			$customer   = Customer::find($request->id);
			$customer->Delete();

			return redirect()->route('customer')
			->with('success','Data Berhasil Dihapus');
		} catch (\Exception $e) {
			return redirect()->route('customer')
			->with('error',$e->getMessage());
		}

	}

	public function destroyCustomerType(Request $request)
	{
		try {
			$crud   = CustomerType::find($request->id);
			$crud->Delete();

			return redirect()->route('customer')
			->with('success','Data Berhasil Dihapus');
		} catch (\Exception $e) {
			return redirect()->route('customer')
			->with('error',$e->getMessage());
		}

	}

	/* UTILITIES */

	public function selectCustomerType(Request $request)
	{
		$select = [];
		try {
			if ($request->has('q')) {
				$search         = $request->q;
				$select         = DB::table('customer_type')
				->select('id','name as text')
				->where('name', 'like', "%$search%")
				->orderBy('name','asc')
				->get();   
			}else {
				$select         = CustomerType::select([
					'id',
					'name as text',
				])
				->orderBy('name','asc')
				->get();
			}

			return response()->json($select);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
	}

	public function selectCustomer(Request $request)
	{
		$select = [];
		try {
			if ($request->has('q')) {
				$search         = $request->q;
				$select         = DB::table('customer')
				->select('id','name as text')
				->where('name', 'like', "%$search%")
				->orderBy('name','asc')
				->get();   
			}else {
				$select         = Customer::select([
					'id',
					'name as text',
				])
				->orderBy('name','asc')
				->get();
			}

			return response()->json($select);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
	}

	public function reportCustomer()
	{
		$customer           = Customer::Customer()
		->orderBy('customer.name','ASC')
		->get();

		$pdf = PDF::loadView('report.customer', compact('customer'));

		return $pdf->stream('customer-report-'.Carbon::now());
	}
}
