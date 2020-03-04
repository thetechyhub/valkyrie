<?php

namespace Modules\Identity\Entities;

use BenSampo\Enum\Traits\CastsEnums;
use Modules\Identity\Enums\RoleOption;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \Modules\Identity\Enums\RoleOption|null $name
 */
class Role extends Model{
	use CastsEnums;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		"name"
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		// attributes
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		// attributes
	];


	/**
	 * The attributes that should be cast to an enum type.
	 *
	 * @var array
	 */
	protected $enumCasts = [
		'name' => RoleOption::class,
	];

	/**
	 * Find Role By Given Name 
	 * 
	 * @param RoleOption $name
	 */
	public static function findByName($name){
		return self::where('name', $name->value)->first();
	}
}
