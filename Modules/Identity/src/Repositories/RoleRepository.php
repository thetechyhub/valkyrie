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
	public static function find($id){
		$role = Identity::role();

		return $role->where($role->getKeyName(), $id)->first();
	}

	/**
	 * Get Adminstrator Role Entity
	 * 
	 * @return \Modules\Identity\Entities\Role
	 */
	public static function getAdministratorRole(){
		$role = Identity::role();
		
		return $role->firstOrCreate([ 'name' => $role::Administrator ]);
	}

	/**
	 * Get Adminstrator Role ID
	 * 
	 * @return int
	 */
	public static function getAdministratorRoleId(){
		return self::getAdministratorRole()->id;
	}


	/**
	 * Get Super Adminstrator Role Entity
	 * 
	 * @return \Modules\Identity\Entities\Role
	 */
	public static function getSuperAdministratorRole(){
		$role = Identity::role();
		
		return $role->firstOrCreate([ 'name' => $role::SuperAdministrator ]);
	}

	/**
	 * Get Super Adminstrator Role ID
	 * 
	 * @return int
	 */
	public static function getSuperAdministratorRoleId(){
		return self::getSuperAdministratorRole()->id;
	}
}
