<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Setting;
use Spatie\Permission\Models\Role;
use DB;
use Hash;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	function __construct()
	{
		$this->middleware('permission:master-users')->except('selectCourier');
	}

	public function index(Request $request)
	{
		$title      = 'Manajemen User - PUDEMAS';
		$data = User::orderBy('id','DESC')->paginate(5);
		return view('users.index',compact('data','title'))
		->with('i', ($request->input('page', 1) - 1) * 5);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$data['title']          = 'Tambah User Baru';
		$roles = Role::pluck('name','name')->all();
		return view('users.create',compact('roles'),$data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|same:confirm-password',
			'roles' => 'required'
		]);

		$input = $request->all();
		$input['password'] = Hash::make($input['password']);

		$user = User::create($input);
		$user->assignRole($request->input('roles'));

		return redirect()->route('users.index')
		->with('success','User created successfully');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$data['title']          = 'Data User';
		$user = User::find($id);
		return view('users.show',compact('user'), $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$data['title']          = 'Edit User';
		$user = User::find($id);
		$roles = Role::pluck('name','name')->all();
		$userRole = $user->roles->pluck('name','name')->all();

		return view('users.edit',compact('user','roles','userRole'), $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email|unique:users,email,'.$id,
			'password' => 'same:confirm-password',
			'roles' => 'required'
		]);

		$input = $request->all();
		if(!empty($input['password'])){ 
			$input['password'] = Hash::make($input['password']);
		}else{
			$input = array_except($input,array('password'));    
		}

		$user = User::find($id);
		$user->update($input);
		DB::table('model_has_roles')->where('model_id',$id)->delete();

		$user->assignRole($request->input('roles'));

		return redirect()->route('users.index')
		->with('success','User updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		User::find($id)->delete();
		return redirect()->route('users.index')
		->with('success','User deleted successfully');
	}

	/**
	 * Utilitier Function
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function selectCourier(Request $request)
	{
		$setting 			= Setting::find(1);
		$id_courier 		= $setting->id_courier;
		$select = [];
		try {
			if ($request->has('q')) {
				$search         = $request->q;
				$select         = DB::table('users')
				->select('users.id','users.name as text')
				->join('model_has_roles','model_has_roles.model_id','=','users.id')
				->where('users.name', 'like', "%$search%")
				->where('users.is_free', '1')
				->where('model_has_roles.role_id', $id_courier)
				->orderBy('users.name','asc')
				->get();   
			}else {
				$select         = User::select([
					'users.id',
					'users.name as text',
				])
				->join('model_has_roles','model_has_roles.model_id','=','users.id')
				->where('users.is_free', '1')
				->where('model_has_roles.role_id', $id_courier)
				->orderBy('users.name','asc')
				->get();
			}

			return response()->json($select);
		} catch (\Exception $e) {
			dd($e->getMessage());
		}
	}
}