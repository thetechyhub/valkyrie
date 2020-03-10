<?php

namespace Modules\Identity\Tests\Unit;

use Modules\Identity\Identity;

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
}
