<?php

namespace Modules\Identity\Repositories;

use BadMethodCallException;
use Modules\Identity\Exceptions\UnSopportedRoleException;

use Modules\Core\Helpers\Common;
use Modules\Identity\Identity;

class RoleRepository {


	/**
	 * functions to get role for a given role name 
	 * 
	 * @var string
	 **/
	private static $getRoleFor = 'getRoleFor';


	/**
	 * functions to get role id for a given role name 
	 * 
	 * @var string
	 **/
	private static $getRoleIdFor = 'getRoleIdFor';



	public static function __callStatic($method, $arguments){

		switch($method){
			case Common::startWith($method, self::$getRoleFor):
				$attribute = Common::getFunctionAttribute($method, self::$getRoleFor);

				return self::getRoleFor($attribute, $arguments);
				break;
			case Common::startWith($method, self::$getRoleIdFor):
				$attribute = Common::getFunctionAttribute($method, self::$getRoleIdFor);
				return self::getRoleIdFor($attribute, $arguments);
				break;
			default:
				throw new BadMethodCallException("Undefined method $method");
				break;
		}
		
	}


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
	public static function getRoleFor($attribute, $arguments){
		$role = Identity::role();
		
		$role =  $role->where('name',  $attribute)->first();

		if(!$role){
			throw new UnSopportedRoleException();
		}

		return $role;
	}

	/**
	 * Get Adminstrator Role ID
	 * 
	 * @return int
	 */
	public static function getRoleIdFor($attribute, $arguments){
		return self::getRoleFor($attribute, $arguments)->id;
	}

}
