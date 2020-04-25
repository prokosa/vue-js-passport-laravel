<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
	use Notifiable, HasApiTokens;
	
	/**
	 * @var string
	 */
	protected $table = 'users';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];
	
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
		'updated_at',
		'deleted_at',
	];
	
	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
		'created_at'        => 'date:Y-m-d',
		'updated_at'        => 'date:Y-m-d',
		'deleted_at'        => 'date:Y-m-d',
	];
	
	//--------------------Accessors & Mutators--------------------//
	
	/**
	 * Set user password
	 *
	 * @param $password
	 */
	public function setPasswordAttribute( $password )
	{
		$this->attributes['password'] = Hash::make( $password );
	}
}
