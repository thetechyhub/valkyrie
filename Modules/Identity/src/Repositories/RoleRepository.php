<?php

namespace Modules\Identity\Repositories;

use Modules\Identity\Identity;

class RoleRepository {


	/**
	 * Get a user by the given ID.
	 *
	 * @param  int  $id
	 * @return \Modules\Identity\Entities\Role|null
	 */
	public function find($id){
		$user = Identity::role();

		return $user->where($user->getKeyName(), $id)->first();
	}
}
