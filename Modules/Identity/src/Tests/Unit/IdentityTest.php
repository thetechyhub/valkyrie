<?php

namespace Modules\Identity\Tests\Unit;

use Modules\Identity\Identity;
use Modules\Identity\Exceptions\UnSopportedRoleException;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IdentityTest extends TestCase{
  
  
  /**
   * @test
   * 
   * @group identity
   * @return void
   */
  public function it_can_get_user_model_instance(){
    $user = Identity::user();

    $this->assertInstanceOf(Identity::userModel(), $user);
  }

  /**
   * @test
   * 
   * @group identity
   * @return void
   */
  public function it_can_get_role_model_instance(){
    $role = Identity::role();

    $this->assertInstanceOf(Identity::roleModel(), $role);
  }


  /**
   * @test
   * 
   * @group identity
   * @return void
   */
  public function it_can_get_supported_roles(){
    $roles = config('app.roles');

    foreach($roles as $roleName){
      $method = 'getRoleFor' . $roleName;
      $role = forward_static_call([Identity::class, $method], []);

      $this->assertInstanceOf(Identity::roleModel(), $role);
      $this->assertTrue($role->name == $roleName);
    }
  }

  /**
   * @test
   * 
   * @group identity
   * 
   * @return void
   */
  public function it_should_throw_exception_for_unsupported_roles(){
    $this->expectException(UnSopportedRoleException::class);

    Identity::getRoleForUnsupportedAttribute();
  }


  /**
   * @test
   * 
   * @group identity
   * @return void
   */
  public function it_can_get_supported_roles_ids(){
    $roles = config('app.roles');
    $role = Identity::role();

    foreach ($roles as $roleName) {
      $method = 'getRoleIdFor' . $roleName;
      $roleId = forward_static_call([Identity::class, $method], []);

      $role = $role::where('name', $roleName)->first();
      $this->assertTrue($role->id == $roleId);
    }
  }


  /**
   * @test
   * 
   * @group identity
   * @return void
   */
  public function it_can_get_supported_roles_ids(){

  }
}
