<?php

namespace Modules\Identity\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable{
	use Notifiable, HasApiTokens;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'email', 'password', 'email_verified_at', 'must_verify_email', 'profile'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'must_verify_email' => 'boolean',
		'email_verified_at' => 'datetime',
		'profile' => 'array',
	];


	/**
	 * User Roles
	 *  
	 */
	public function roles(){
		return $this->belongsToMany(Role::class, 'user_roles');
	}

	/**
	 * Is user account verified 
	 * 
	 **/
	public function getIsVerifiedAttribute(){
		return $this->email_verified_at || !$this->must_verify_email;
	}
}
