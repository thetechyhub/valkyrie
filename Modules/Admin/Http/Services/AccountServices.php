<?php

namespace Modules\Core\Http\Services;

use Modules\Identity\Identity;
use Modules\Core\Helpers\Response;

class AccountServices extends TransformerService{


	public static function profile(){ 
		$user = Identity::currentUser();

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