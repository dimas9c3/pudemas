<?php

namespace App\Http\Controllers;

use App\User;
use App\Setting;
use Spatie\Permission\Models\Role;
use DB;

use Illuminate\Http\Request;

class CourierController extends Controller
{
	public function index(Request $request)
	{
		$title      		= 'Data Kurir - PUDEMAS';

		$setting 			= Setting::find(1);
		$id_courier 		= $setting->id_courier;
		$data 				= User::orderBy('name','ASC')
		->join('model_has_roles','model_has_roles.model_id','=','users.id')
		->where('model_has_roles.role_id', $id_courier)
		->paginate(5);

		return view('courier',compact('data','title'))
		->with('i', ($request->input('page', 1) - 1) * 5);
	}
}
