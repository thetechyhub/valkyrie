<?php

namespace Modules\Core\Http\Services;

use Modules\Core\Helpers\Common;
use Modules\Core\Helpers\Response;

class AccountServices extends TransformerService{


	public static function profile(){ 
		$user = Common::currentUser();

		return Response::create(self::transform($user));
	}

	public static function transform($user){
		return [
			"id" => $user->id,
			"email" => $user->email,
			"profile" => $user->profile,
		];
	}
}