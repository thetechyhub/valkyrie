<?php

namespace Modules\Core\Helpers;

use Illuminate\Support\Facades\Auth;

class Common {

	/**
	 * Return current authenticated admin
	 *
	 * @return user
	 */
	public static function currentUser($guard = null){
		return Auth::guard($guard)->user();
	}
}