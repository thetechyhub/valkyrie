<?php

namespace Modules\Core\Http\Services;

use Modules\Identity\Identity;
use Modules\Core\Helpers\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthServices{


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
		$roleId = Identity::getRoleIdForAdmin();

		$user = Identity::findUserByEmailAndRoleId($data['email'], $roleId);

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

		$result = Identity::createAccessToken($data);

		return Response::create($result);
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