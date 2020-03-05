<?php

namespace Modules\Core\Http\Services;

use App\Services\Shared\TransformerService;

class ProfileServices extends TransformerService{


	public static function profile(){ 
		$user = current_user();

		return (new self)->transform($user);
	}

	public function transform($user){
		return [
			"id" => $user->id,
			"email" => $user->email,
			"profile" => $user->profile,
		];
	}
}