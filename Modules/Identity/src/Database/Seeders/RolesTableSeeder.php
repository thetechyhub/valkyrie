<?php

namespace Modules\Identity\Database\Seeders;

use Modules\Identity\Enums\RoleOption;
use Modules\Identity\Entities\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesTableSeeder extends Seeder{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(){
    Role::truncate();

    
    Role::create(['name' => RoleOption::SuperAdministrator]);
    Role::create(['name' => RoleOption::Administrator]);
    Role::create(['name' => RoleOption::Client]);
  }
}
