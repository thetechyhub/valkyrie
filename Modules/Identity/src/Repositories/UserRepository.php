<?php

namespace Modules\Identity\Repositories;

use Modules\Identity\Identity;

class UserRepository {


	/**
	 * Get a user by the given ID.
	 *
	 * @param  int  $id
	 * @return \Modules\Identity\Entities\User|null
	 */
	public function find($id){
		$user = Identity::user();

		return $user->where($user->getKeyName(), $id)->first();
	}
}
