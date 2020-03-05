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
		"name" => "int"
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
	 * User Roles
	 *  
	 */
	public function users(){
		return $this->belongsToMany(User::class, 'user_roles');
	}
}
