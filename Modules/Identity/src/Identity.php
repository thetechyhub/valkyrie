<?php

namespace Modules\Identity;

class Identity {

	/**
	 * The user model class name.
	 *
	 * @var string
	 */
	public static $userModel = 'Modules\Identity\Entities\User';

	/**
	 * The role model class name.
	 *
	 * @var string
	 */
	public static $roleModel = 'Modules\Identity\Entities\Role';

	/**
	 * The verify token model class name.
	 *
	 * @var string
	 */
	public static $verifyTokenModel = 'Modules\Identity\Entities\VerifyToken';

	/**
	 * Get the user model class name.
	 *
	 * @return string
	 */
	public static function userModel(){
		return static::$userModel;
	}

	/**
	 * Get a new user model instance.
	 *
	 * @return \Modules\Identity\Entities\User
	 */
	public static function user(){
		return new static::$userModel;
	}

	/**
	 * Get the role model class name.
	 *
	 * @return string
	 */
	public static function roleModel(){
		return static::$roleModel;
	}

	/**
	 * Get a new role model instance.
	 *
	 * @return \Modules\Identity\Entities\Role
	 */
	public static function role(){
		return new static::$roleModel;
	}

	/**
	 * Get the verify token model class name.
	 *
	 * @return string
	 */
	public static function verifyTokenModel(){
		return static::$verifyTokenModel;
	}

	/**
	 * Get a new verify token model instance.
	 *
	 * @return \Modules\Identity\Entities\VerifyToken
	 */
	public static function verifyToken(){
		return new static::$verifyTokenModel;
	}

	/**
	 * Create user from attributes.
	 *
	 * @param array $attributes
	 * @return \Modules\Identity\Entities\User
	 */
	public static function createUser($attribute){
		//
	}

	/**
	 * Verify account for the specified user
	 *
	 * @param array $attributes
	 * @return \Modules\Identity\Entities\User
	 */
	public static function verifyAccount($token){
		//
	}

	/**
	 * Reset password for the specified user
	 *
	 * @param array $attributes
	 * @return \Modules\Identity\Entities\User
	 */
	public static function resetPassword($token, $password){
		//
	}

	/**
	 * Create verify token from attributes.
	 *
	 * @param array $attributes
	 * @return \Modules\Identity\Entities\VerifyToken
	 */
	public static function createVerifyToken($attribute){
		//
	}

	/**
	 * Revoke verify token for the specified user
	 *
	 * @param int $userId
	 * @return void
	 */
	public static function revokeVerifyTokenFor($userId){
		//
	}


	/**
	 * Revoke verify token for the specified user
	 *
	 * @param string $token
	 * @return void
	 */
	public static function revokeVerifyToken($token){
		//
	}


	/**
	 * Create access token from attributes.
	 *
	 * @param array $attributes
	 * @return \Illuminate\Http\Response
	 */
	public static function createAccessToken($attribute){
		//
	}

	/**
	 * Revoke access token for the specified user.
	 *
	 * @param int $userId
	 * @return void
	 */
	public static function revokeAccessTokenFor($userId){
		//
	}

	/**
	 * Revoke access all tokens for the specified user.
	 *
	 * @param int $userId
	 * @return void
	 */
	public static function revokeAccessTokensFor($userId){
		//
	}

	/**
	 * Create refresh token from attributes.
	 *
	 * @param array $attributes
	 * @return \Illuminate\Http\Response
	 */
	public static function createRefreshToken($attribute){
		//
	}
}