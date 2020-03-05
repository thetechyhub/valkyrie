<?php

namespace Modules\Identity\Entities;

use Illuminate\Database\Eloquent\Model;

class User extends Model{

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
		return $this->belongsToMany(Role::class);
	}

	/**
	 * Check if use has a specific role
	 *  
	 */
	public function getHasRoleAttribute($role){
		return $this->roles()->where('name', $role)->first() != null;
	}

	/**
	 * Is user account verified 
	 * 
	 **/
	public function getIsVerifiedAttribute(){
		return $this->email_verified_at || !$this->must_verify_email;
	}

	/**
	 * Find the user instance for the given username.
	 *
	 * This used for passport token issuing process
	 * 
	 * @param  string  $username
	 * @return \App\User
	 */
	public function findForPassport($username){
		list($email, $role_id) = explode(' ', $username);

		return $this->where('email', $email)
			->whereHas('roles', function($query) use($role_id){
				$query->where('id', $role_id);
			})->first();
	}


	/**
	 * Find user by email and role id 
	 * 
	 * @param string $email
	 * @param int $role_id
	 * @return User
	 **/
	public static function findByEmailAndRoleId($email, $role_id){
		return self::where('email', $email)
			->whereHas('roles', function ($query) use ($role_id) {
				$query->where('id', $role_id);
			})->first();
	}
}
