<?php

namespace Modules\Admin\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Http\Services\AuthServices;

class AuthController extends Controller{

	/**
	 * Register user
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 **/
	public function register(Request $request){
		return AuthServices::register($request);
	}

	/**
	 * Login user
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 **/
	public function login(Request $request){
		return AuthServices::login($request);
	}

	/**
	 * Relogin user by refreshing his/her access token
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 **/
	public function refresh(Request $request){
		return AuthServices::refresh($request);
	}

	/**
	 * Logout the user
	 * 
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 **/
	public function logout(Request $request){
		return AuthServices::logout($request);
	}
}
