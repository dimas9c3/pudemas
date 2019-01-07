<?php

namespace App\Http\Controllers;

use App\Item;
use App\ItemCategory1;
use App\ItemCategory2;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Validator;
use Image;
use Storage;
use Session;

class ItemController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	function __construct()
    {
         $this->middleware('permission:master-items');
    }

	public function index()
	{
		$data['title']          = 'Data Barang - PUDEMAS';
		$data['page']           = 'Data Barang';
		return view('item')->with($data);
	}

	public function getItem()
	{
		try {
			DB::statement(DB::raw('set @rownum=0'));

			$Item = Item::select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'item.id',
				'item.image',
				'item.name',
				'item.purchase_price',
				'item.selling_price',
				'item_category1.name as kategori',
				'item_category2.name as merk',
			])
			->join('item_category1','item_category1.id','=','item.item_category1')
			->join('item_category2','item_category2.id','=','item.item_category2')
			->orderBy('item.name','asc')
			->get();

			return Datatables::of($Item)
			->addColumn('foto', function ($Item) {
				if (!empty($Item->image)) {
					return '
					<img class="rounded-circle" src="'.asset('storage/images/item/thumbnail/'.$Item->image).'" style="width:100px;height:100px;" />';
				// if image is empty
				}else {
					return '
					<img class="rounded-circle" src="'.asset('storage/images/item/item-template.png').'" style="width:100px;height:100px;" />';
				}

			})

			->addColumn('action', function ($Item) {
				return '
				<button type="button" id="'.$Item->id.'" image="'.$Item->image.'" class="btn btn-info btn-sm mr-1 mb-2 button-update"><i class="la la-edit edit"></i></button>
				<button type="button" id="'.$Item->id.'" image="'.$Item->image.'" class="btn btn-danger btn-sm mr-1 mb-2 button-destroy"><i class="la la-close delete"></i></button>';
			})
			->editColumn('purchase_price', function($Item) {
				return 'Rp. '.number_format($Item->purchase_price);
			})
			->editColumn('selling_price', function($Item) {
				return 'Rp. '.number_format($Item->selling_price);
			})
			->rawColumns(['foto', 'action'])
			->make(true);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}  
	}

	public function getItemById(Request $request)
	{	
		try {
			$Item 		= Item::select([
				'item.id',
				'item.name',
				'item.purchase_price',
				'item.selling_price',
				'item.image',
				'item_category1.id as id_kategori',
				'item_category1.name as kategori',
				'item_category2.id as id_merk',
				'item_category2.name as merk',
			])
			->join('item_category1','item_category1.id','=','item.item_category1')
			->join('item_category2','item_category2.id','=','item.item_category2')
			->where('item.id', $request->id)
			->get();

			return response()->json($Item);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
	}

	public function getItemCategory1()
	{
		try {
			DB::statement(DB::raw('set @rownum=0'));

			$ItemCategory1   = ItemCategory1::select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'id',
				'name',
			])
			->orderBy('name','asc')
			->get();

			return Datatables::of($ItemCategory1)
			->addColumn('action', function ($ItemCategory1) {
				return '
				<button type="button" id="'.$ItemCategory1->id.'" name="'.$ItemCategory1->name.'" class="btn btn-info btn-sm mr-1 mb-2 button-update"><i class="la la-edit edit"></i></button>
				<button type="button" id="'.$ItemCategory1->id.'" class="btn btn-danger btn-sm mr-1 mb-2 button-destroy"><i class="la la-close delete"></i></button>';
			})
			->make(true);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}  
	}

	public function getItemCategory2()
	{
		try {
			DB::statement(DB::raw('set @rownum=0'));

			$ItemCategory2   = ItemCategory2::select([
				DB::raw('@rownum  := @rownum  + 1 AS rownum'),
				'id',
				'name',
			])
			->orderBy('name','asc')
			->get();

			return Datatables::of($ItemCategory2)
			->addColumn('action', function ($ItemCategory2) {
				return '
				<button type="button" id="'.$ItemCategory2->id.'" name="'.$ItemCategory2->name.'" class="btn btn-info btn-sm mr-1 mb-2 button-update"><i class="la la-edit edit"></i></button>
				<button type="button" id="'.$ItemCategory2->id.'" class="btn btn-danger btn-sm mr-1 mb-2 button-destroy"><i class="la la-close delete"></i></button>';
			})
			->make(true);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}  
	}

	public function getItemPickup(Request $request) 
	{
		try {

			if (!empty(session('item-pickup'))) {
				$data 		= array();

				foreach (session('item-pickup') as $i) {
					$row 		= array();
					$row[]		= $i['nm_item'];
					$row[]		= $i['nm_supplier'];
					$row[]		= $i['qty'];
					$row[]		= 'Rp. '.number_format($i['purchase_price']);
					$row[]		= 'Rp. '.number_format($i['qty']*$i['purchase_price']);

					$data[]		= $row;
				}
			}else {
				$data 		= array();
			}
			

			$ajax 			= array(
				'data'		=> $data,
			);

			return response()->json($ajax);
		} catch (\Exception $e) {
			return response()->json($e->getMessage());
		}

		
	}

	public function getItemDelivery(Request $request) 
	{
		try {

			if (!empty(session('item-delivery'))) {
				$data 		= array();

				foreach (session('item-delivery') as $i) {
					$row 		= array();
					$row[]		= $i['nm_item'];
					$row[]		= $i['qty'];
					$row[]		= 'Rp. '.number_format($i['selling_price']);
					$row[]		= 'Rp. '.number_format($i['qty']*$i['selling_price']);

					$data[]		= $row;
				}
			}else {
				$data 		= array();
			}
			

			$ajax 			= array(
				'data'		=> $data,
			);

			return response()->json($ajax);
		} catch (\Exception $e) {
			return response()->json($e->getMessage());
		}

		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeItem(Request $request)
	{
		try {
			if ($request->hasFile('image')) {
				$attributeNames = array(
					'item_category1' 	=> 'Kategori',
					'item_category2' 	=> 'Merk',     
					'name' 				=> 'Nama',
					'purchase_price'	=> 'Harga Beli',
					'selling_price'		=> 'Harga Jual',
					'image'				=> 'Foto',
				);

				$validator      = Validator::make($request->all(),[
					'item_category1'    => 'required',
					'item_category2'    => 'required',
					'name'              => 'required|min:2|',
					'purchase_price'    => 'required|numeric',
					'selling_price'     => 'required|numeric|gte:purchase_price',
					'image'             => 'image|mimes:jpeg,bmp,png,jpg',
				]);

				$validator->setAttributeNames($attributeNames);

				if ($validator->fails()) {
					return redirect()->route('item')
					->withErrors($validator)
					->withInput();
				}

				$file = $request->file('image');
				//get filename with extension
				$filenamewithextension = $file->getClientOriginalName();

				//get filename without extension
				$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

				//get file extension
				$extension = $file->getClientOriginalExtension();

				//filename to store
				$filenametostore = $filename.'_'.uniqid().'.'.$extension;

				//thumbnail path
				$thumbnailpath = public_path('storage/images/item/thumbnail/'.$filenametostore);

				//Resize image here
				$image = Image::make($file->getRealPath());

				$image->fit(300, 300, function ($constraint) {
					$constraint->aspectRatio();
				})->save($thumbnailpath);

				// Store Original image size
				Storage::put('public/images/item/'. $filenametostore, fopen($file, 'r+'));

				$item = new Item();
				$item->item_category1   = $request->item_category1;
				$item->item_category2   = $request->item_category2;
				$item->name             = $request->name;
				$item->purchase_price   = $request->purchase_price;
				$item->selling_price    = $request->selling_price;
				$item->image            = $filenametostore;
				$item->save();

				return redirect()->route('item')
				->with('success', 'Data Barang Berhasil Disimpan');
			}else {
				$attributeNames = array(
					'item_category1' 	=> 'Kategori',
					'item_category2' 	=> 'Merk',     
					'name' 				=> 'Nama',
					'purchase_price'	=> 'Harga Beli',
					'selling_price'		=> 'Harga Jual',
					'image'				=> 'Foto',
				);

				$validator      = Validator::make($request->all(),[
					'item_category1'    => 'required',
					'item_category2'    => 'required',
					'name'              => 'required|min:2|',
					'purchase_price'    => 'required|numeric',
					'selling_price'     => 'required|numeric|gte:purchase_price',
				]);

				$validator->setAttributeNames($attributeNames);

				if ($validator->fails()) {
					return redirect()->route('item')
					->withErrors($validator)
					->withInput();
				}

				$item = new Item();
				$item->item_category1   = $request->item_category1;
				$item->item_category2   = $request->item_category2;
				$item->name             = $request->name;
				$item->purchase_price   = $request->purchase_price;
				$item->selling_price    = $request->selling_price;
				$item->save();

				return redirect()->route('item')
				->with('success', 'Data Barang Berhasil Disimpan');
			}

		} catch (\Exception $e) {
			return redirect()->route('item')
			->with('error', $e->getMessage());
		}
	}

	public function storeItemPickup(Request $request)
	{
		try {
			if ($request->is_send == 1) {
				// Fetch Item data
				$item 			= Item::find($request->id);
				$id_item		= $item->id;
				$nm_item 		= $item->name;

				// Fetch Supplier data
				$supplier 		= Supplier::find($request->supplier);
				$id_supplier 	= $supplier->id;
				$nm_supplier 	= $supplier->name;

				$session 		= array(
					'id_item'			=> $id_item,
					'nm_item'			=> $nm_item,
					'id_supplier'		=> $id_supplier,
					'nm_supplier'		=> $nm_supplier,
					'qty'				=> $request->qty,
					'purchase_price'	=> $request->purchase_price,
				);

				$delivery 		= array(
					'id_item'			=> $id_item,
					'nm_item'			=> $nm_item,
					'qty'				=> $request->qty,
					'selling_price'		=> $request->selling_price,

				);

				$request->session()->push('item-pickup', $session);
				$request->session()->push('item-delivery', $delivery);
			}else {
				// Fetch Item data
				$item 			= Item::find($request->id);
				$id_item		= $item->id;
				$nm_item 		= $item->name;

				// Fetch Supplier data
				$supplier 		= Supplier::find($request->supplier);
				$id_supplier 	= $supplier->id;
				$nm_supplier 	= $supplier->name;

				$session 		= array(
					'id_item'			=> $id_item,
					'nm_item'			=> $nm_item,
					'id_supplier'		=> $id_supplier,
					'nm_supplier'		=> $nm_supplier,
					'qty'				=> $request->qty,
					'purchase_price'	=> $request->purchase_price,
				);

				$request->session()->push('item-pickup', $session);
			}
			

			return response()->json($request);
		} catch (\Exception $e) {
			return response()->json($e->getMessage());
		}
		
	}

	public function storeItemCategory1(Request $request)
	{
		try {
			$validator = Validator::make($request->all(),[
				'name' => 'required|min:2',
			]);

			if ($validator->fails()) {
				return redirect()->route('item')
				->withErrors($validator)
				->withInput();
			}

			$crud               = new ItemCategory1;
			$crud->name         = $request->name;
			$crud->save();

			return redirect()->route('item')
			->with('success','Data Kategori Barang Berhasil Disimpan.');
		}catch (\Exception $e) {
			return redirect()->route('item')
			->with('error',$e->getMessage());
		}

	}

	public function storeItemCategory2(Request $request)
	{
		try {
			$validator = Validator::make($request->all(),[
				'name' => 'required|min:2',
			]);

			if ($validator->fails()) {
				return redirect()->route('item')
				->withErrors($validator)
				->withInput();
			}

			$crud               = new ItemCategory2;
			$crud->name         = $request->name;
			$crud->save();

			return redirect()->route('item')
			->with('success','Data Merk Barang Berhasil Disimpan.');
		}catch (\Exception $e) {
			return redirect()->route('item')
			->with('error',$e->getMessage());
		}

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\ItemCategory2  $itemCategory2
	 * @return \Illuminate\Http\Response
	 */
	public function updateItem(Request $request)
	{
		try {
			if ($request->hasFile('image')) {
				$attributeNames = array(
					'item_category1' 	=> 'Kategori',
					'item_category2' 	=> 'Merk',     
					'name' 				=> 'Nama',
					'purchase_price'	=> 'Harga Beli',
					'selling_price'		=> 'Harga Jual',
					'image'				=> 'Foto',
				);

				$validator      = Validator::make($request->all(),[
					'item_category1'    => 'required',
					'item_category2'    => 'required',
					'name'              => 'required|min:2|',
					'purchase_price'    => 'required|numeric',
					'selling_price'     => 'required|numeric|gte:purchase_price',
					'image'             => 'image|mimes:jpeg,bmp,png,jpg',
				]);

				$validator->setAttributeNames($attributeNames);

				if ($validator->fails()) {
					return redirect()->route('item')
					->withErrors($validator)
					->withInput();
				}

				//Delete old image
				if ($request->has('image_old')) {
					$file_path 		= 'public/images/item/'.$request->image_old;
					$thumbnail_path = 'public/images/item/thumbnail/'.$request->image_old;
					$del 		 	= Storage::delete([$file_path, $thumbnail_path]);
				}
				
				$file = $request->file('image');
				//get filename with extension
				$filenamewithextension = $file->getClientOriginalName();

				//get filename without extension
				$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

				//get file extension
				$extension = $file->getClientOriginalExtension();

				//filename to store
				$filenametostore = $filename.'_'.uniqid().'.'.$extension;

				//thumbnail path
				$thumbnailpath = public_path('storage/images/item/thumbnail/'.$filenametostore);

				//Resize image here
				$image = Image::make($file->getRealPath());

				$image->fit(300, 300, function ($constraint) {
					$constraint->aspectRatio();
				})->save($thumbnailpath);

				// Store Original image size
				Storage::put('public/images/item/'. $filenametostore, fopen($file, 'r+'));

				$item 					= Item::find($request->id);
				$item->item_category1   = $request->item_category1;
				$item->item_category2   = $request->item_category2;
				$item->name             = $request->name;
				$item->purchase_price   = $request->purchase_price;
				$item->selling_price    = $request->selling_price;
				$item->image            = $filenametostore;
				$item->save();

				return redirect()->route('item')
				->with('success', 'Data Barang Berhasil Disimpan');
			}else {
				$attributeNames = array(
					'item_category1' 	=> 'Kategori',
					'item_category2' 	=> 'Merk',     
					'name' 				=> 'Nama',
					'purchase_price'	=> 'Harga Beli',
					'selling_price'		=> 'Harga Jual',
				);

				$validator      = Validator::make($request->all(),[
					'item_category1'    => 'required',
					'item_category2'    => 'required',
					'name'              => 'required|min:2|',
					'purchase_price'    => 'required|numeric',
					'selling_price'     => 'required|numeric|gte:purchase_price',
				]);

				$validator->setAttributeNames($attributeNames);

				if ($validator->fails()) {
					return redirect()->route('item')
					->withErrors($validator)
					->withInput();
				}

				$item 					= Item::find($request->id);
				$item->item_category1   = $request->item_category1;
				$item->item_category2   = $request->item_category2;
				$item->name             = $request->name;
				$item->purchase_price   = $request->purchase_price;
				$item->selling_price    = $request->selling_price;
				$item->save();

				return redirect()->route('item')
				->with('success', 'Data Barang Berhasil Diedit');
			}

		} catch (\Exception $e) {
			return redirect()->route('item')
			->with('error', $e->getMessage());
		}
	}

	public function updateItemCategory1(Request $request)
	{
		try {
			$validator = Validator::make($request->all(),[
				'name' => 'required|min:2',
			]);

			if ($validator->fails()) {
				return redirect()->route('item')
				->withErrors($validator)
				->withInput();
			}

			$crud               = ItemCategory1::find($request->id);
			$crud->name         = $request->name;
			$crud->save();

			return redirect()->route('item')
			->with('success','Data Berhasil Diubah');
		} catch (\Exception $e) {
			return redirect()->route('item')
			->with('error',$e->getMessage());
		}
	}

	public function updateItemCategory2(Request $request)
	{
		try {
			$validator = Validator::make($request->all(),[
				'name' => 'required|min:2',
			]);

			if ($validator->fails()) {
				return redirect()->route('item')
				->withErrors($validator)
				->withInput();
			}

			$crud               = ItemCategory2::find($request->id);
			$crud->name         = $request->name;
			$crud->save();

			return redirect()->route('item')
			->with('success','Data Berhasil Diubah');
		} catch (\Exception $e) {
			return redirect()->route('item')
			->with('error',$e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\ItemCategory2  $itemCategory2
	 * @return \Illuminate\Http\Response
	 */

	public function destroyItem(Request $request)
	{
		try {
			if ($request->has('image')) {
				$file_path 		= 'public/images/item/'.$request->image;
				$thumbnail_path = 'public/images/item/thumbnail/'.$request->image;
				$Item 		 	= Storage::delete([$file_path, $thumbnail_path]);
			}
			
			$Item   = Item::find($request->id);
			$Item->Delete();
			return redirect()->route('item')
			->with('success','Data Berhasil Dihapus');
		} catch (\Exception $e) {
			return redirect()->route('item')
			->with('error',$e->getMessage());
		}

	}

	public function destroyItemPickup(Request $request)
	{
		try {
			$request->session()->forget('item-pickup');

			return response()->json($request);
		} catch (\Exception $e) {
			return response()->json($e->getMessage());
		}	
	}

	public function destroyItemDelivery(Request $request)
	{
		try {
			$request->session()->forget('item-delivery');

			return response()->json($request);
		} catch (\Exception $e) {
			return response()->json($e->getMessage());
		}	
	}

	public function destroyItemCategory1(Request $request)
	{
		try {
			$crud   = ItemCategory1::find($request->id);
			$crud->Delete();

			return redirect()->route('item')
			->with('success','Data Berhasil Dihapus');
		} catch (\Exception $e) {
			return redirect()->route('item')
			->with('error',$e->getMessage());
		}

	}

	public function destroyItemCategory2(Request $request)
	{
		try {
			$crud   = ItemCategory2::find($request->id);
			$crud->Delete();

			return redirect()->route('item')
			->with('success','Data Berhasil Dihapus');
		} catch (\Exception $e) {
			return redirect()->route('item')
			->with('error',$e->getMessage());
		}

	}

	public function selectItem(Request $request)
	{
		$select = [];
		try {
			if ($request->has('q')) {
				$search         = $request->q;
				$select         = DB::table('item')
				->select('id','name as text')
				->where('name', 'like', "%$search%")
				->orderBy('name','asc')
				->get();   
			}else {
				$select         = Item::select([
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

	public function selectItemCategory1(Request $request)
	{
		$select = [];
		try {
			if ($request->has('q')) {
				$search         = $request->q;
				$select         = DB::table('item_category1')
				->select('id','name as text')
				->where('name', 'like', "%$search%")
				->orderBy('name','asc')
				->get();   
			}else {
				$select         = ItemCategory1::select([
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

	public function selectItemCategory2(Request $request)
	{
		$select = [];
		try {
			if ($request->has('q')) {
				$search         = $request->q;
				$select         = DB::table('item_category2')
				->select('id','name as text')
				->where('name', 'like', "%$search%")
				->orderBy('name','asc')
				->get();   
			}else {
				$select         = ItemCategory2::select([
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
}
