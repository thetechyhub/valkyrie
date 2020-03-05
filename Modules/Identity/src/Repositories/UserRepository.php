<?php

namespace Modules\Identity\Repositories;

use Modules\Identity\Identity;
use Illuminate\Support\Facades\Hash;

class UserRepository {


	/**
	 * Create user from attributes
	 * 
	 * @param array $attributes
	 * @return \Modules\Identity\Entities\User
	 */
	public static function create($attributes, $roleId, $mustVerifyEmail){
		$password = $attributes['password'];

		if($password){
			$attributes['password'] = Hash::make($password);
		}

		$user = Identity::user()->forceFill($attributes);
		$user->must_verify_email = $mustVerifyEmail;
		$user->email_verified_at = $mustVerifyEmail ? now() : null;
		$user->save();

		$user->roles()->attach($roleId);

		return $user;
	}


	/**
	 * Get a user by the given ID.
	 *
	 * @param  int  $id
	 * @return \Modules\Identity\Entities\User|null
	 */
	public static function find($id){
		$user = Identity::user();

		return $user->where($user->getKeyName(), $id)->first();
	}


	/**
	 * Find user by email and role id 
	 * 
	 * @param string $email
	 * @param int $roleId
	 * @return \Modules\Identity\Entities\User|null
	 **/
	public static function findByEmailAndRoleId($email, $roleId){
		$user = Identity::user();

		return $user->where('email', $email)
			->whereHas('roles', function ($query) use ($roleId) {
				$query->where('roles.id', $roleId);
			})->first();
	}
}
