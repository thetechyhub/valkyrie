<?php

namespace Modules\Identity\Repositories;

use Modules\Identity\Identity;
use Modules\Identity\Entities\VerifyToken;
use Modules\Identity\Exceptions\InvalidTokenException;

use Illuminate\Support\Facades\Hash;

class VerifyTokenRepository {


	/**
	 * Create Verify Token for the given user
	 * 
	 * @param array $attributes
	 * @param int $userId
	 * @return VerifyToken
	 **/
	public static function createVerifyToken($attributes, $userId): VerifyToken{
		$verifyToken = Identity::verifyToken();

		$attributes['user_id'] = $userId;

		$verifyToken = $verifyToken::create($attributes);

		return $verifyToken;
	}


	/**
	 * Verify the user account with the given token 
	 * 
	 * @param string $token
	 * @return void
	 */
	public static function verifyAccount($token): void{
		$verifyToken = Identity::verifyToken();

		$token = $verifyToken::where('token', $token)
			->where('used_for', $verifyToken::EMAIL)
			->where('expire_in', '>', now())
			->where('used_at', null)
			->where('revoked', false)
			->first();

		if(!$token){
			throw new InvalidTokenException();
		}

		$user = $token->user;

		if(!$user){
			throw new InvalidTokenException();
		}

		$user->email_verified_at = now();
		$user->save();

		$token->used_at = now();
		$token->save();
	}


	/**
	 * reset the user password
	 * 
	 * @param string $token
	 * @param string $password
	 * @return void
	 */
	public static function resetPassword($token, $password): void{
		$verifyToken = Identity::verifyToken();

		$token = $verifyToken::where('token', $token)
			->where('used_for', $verifyToken::PASSWORD)
			->where('expire_in', '>', now())
			->where('used_at', null)
			->where('revoked', false)
			->first();

		if(!$token){
			throw new InvalidTokenException();
		}

		$user = $token->user;

		if(!$user){
			throw new InvalidTokenException();
		}

		$user->password = Hash::make($password);
		$user->save();

		$token->used_at = now();
		$token->save();
	}

	/**
	 * Revoke all verification tokens for the given user
	 * 
	 * @param int $userId
	 * @return void
	 **/
	public static function revokeVerifyTokensFor($userId): void{
		$verifyToken = Identity::verifyToken();

		$verifyToken::where('user_id', $userId)
			->where('revoked', false)
			->update(['revoked' => true]);
	}

	/**
	 * Revoke the given verification token
	 * 
	 * @param string $token
	 * @return void
	 **/
	public static function revokeVerifyToken($token): void{
		$verifyToken = Identity::verifyToken();

		$verifyToken::where('token', $token)->update(['revoked' => true]);
	}
}