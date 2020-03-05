<?php

namespace Modules\Identity\Enums;

use BenSampo\Enum\Enum;

final class RoleOption extends Enum{
	const SuperAdministrator = 0;
	const Administrator = 1;
	const Client = 2;


	public static function getDescription($value): string{

		switch($value){
			case self::SuperAdministrator:
				return "User with super admin privileges have access to almost everything in this project.";
				break;
			case self::Administrator:
				return "User with admin privileges have similar access to the super admin but with some restrictions.";
				break;
			case self::Client:
				return "User with client privileges have restricted access to the project components.";
				break;
		}
		return parent::getDescription($value);
	}
}
