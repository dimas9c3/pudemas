<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Setting;

class User extends Authenticatable
{
	use HasApiTokens, Notifiable;
	use HasRoles;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function scopeCourier($query)
	{
		$setting 					= Setting::find(1);
		return $query->select('*')
		->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
		->where('model_has_roles.role_id', $setting->id_courier);
	}
}
