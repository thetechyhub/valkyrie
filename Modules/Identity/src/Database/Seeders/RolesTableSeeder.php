<?php

namespace Modules\Identity\Database\Seeders;

use Modules\Identity\Entities\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(){
    Role::truncate();

    
    Role::create(['name' => Role::SuperAdministrator]);
    Role::create(['name' => Role::Administrator]);
    Role::create(['name' => Role::Client]);
  }
}
