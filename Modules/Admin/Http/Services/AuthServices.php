<?php

namespace Modules\Core\Http\Services;

use Modules\Identity\Identity;
use Modules\Core\Helpers\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthServices{


	/**
	 * Register new user based on given scope
	 * 
	 * 
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 **/
	public static function register(Request $request){
		$validator = Validator::make($request->all(), [
			'email' => 'required|unique:users',
			'password' => 'required|min:6|confirmed',
		]);

		if ($validator->fails()) {
			return Response::validationError(['message' => $validator->errors()->first()]);
		}

		$data = $validator->validated();
		$administratorRoleId = Identity::getAdministratorRoleId();
		
		$user = Identity::createUser($data, $administratorRoleId);

		$data['user_id'] = $user->id;
		$data['client_id'] = $request->header('client-id');
		$data['client_secret'] = $request->header('client-secret');

		$response = Identity::createAccessToken($data);

		return $response;
	}

	/**
	 * Login the user
	 * 
	 * 
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 **/
	public static function login(Request $request){
		$validator = Validator::make($request->all(), [
			'email' => 'required',
			'password' => 'required|min:6',
		]);

		if ($validator->fails()) {
			return Response::validationError(['message' => $validator->errors()->first()]);
		}

		$data = $validator->validated();
		$administratorRoleId = Identity::getAdministratorRoleId();

		$user = Identity::findUserByEmailAndRoleId($data['email'], $administratorRoleId);

		if(!$user){
			return Response::validationError([
				'message' => 'Email or password is incorrect',
			]);
		}

		if(!Hash::check($data['password'], $user->password)){
			return Response::validationError([
				'message' => 'Email or password is incorrect',
			]);			
		}

		$data['user_id'] = $user->id;
		$data['client_id'] = $request->header('client-id');
		$data['client_secret'] = $request->header('client-secret');

		$response = Identity::createAccessToken($data);

		return $response;
	}


	/**
	 * Relogin the user by refreshing his/her access token.
	 * 
	 * 
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 **/
	public static function refresh(Request $request){
		$data['refresh_token'] = $request->refresh_token;
		$data['client_id'] = $request->header('client-id');
		$data['client_secret'] = $request->header('client-secret');

		$response = Identity::refreshAccessToken($data);

		return $response;
	}

	/**
	 * Logout the user by revoking their access
	 * 
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 **/
	public static function logout(Request $request){
		$user = Identity::currentUser();
		$data = [
			'user_id' => $user->id,
			'client_id' => $request->header('client-id'),
		];

		Identity::revokeUserAccess($data);
		return Response::success();
	}
}