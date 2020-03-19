<?php

namespace Modules\Identity\Tests\Unit;

use Modules\Identity\Identity;
use Modules\Identity\Exceptions\UnSopportedRoleException;
use Modules\Identity\Exceptions\InvalidTokenException;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Client;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IdentityTest extends TestCase{
  use RefreshDatabase;

  /**
   * Supported Roles
   * 
   */
  protected $supportedRoles;

  /**
   * Setup the test environment.
   *
   * @return void
   */
  protected function setUp(): void{
    parent::setUp();
    
    $this->supportedRoles = config('identity.roles');
  }

  /**
   * Get Supported Roles
   * 
   * @param callable $callable
   * @return void
   */
  public function supportedRoles(callable $callable){
    foreach ($this->supportedRoles as $roleName) {
      $method = 'getRoleIdFor' . $roleName;
      $roleId = forward_static_call([Identity::class, $method], []);

      $callable($roleId);
    }
  }

  /**
   * Create Test user with role
   * 
   * @param string $state
   * @param int $roleId
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function createUser($state = null, $roleId){
    if($state){
      $usersFactory = factory(Identity::userModel(), 10)
        ->states($state)
        ->create()
        ->each(function ($user) use ($roleId) {
          $user->roles()->attach($roleId);
        });
    }else{
      $usersFactory = factory(Identity::userModel(), 10)
        ->create()
        ->each(function ($user) use ($roleId) {
          $user->roles()->attach($roleId);
        });
    }

    return $usersFactory->random();
  }

  /**
   * Create passport client setup
   * 
   * @return Client
   **/
  public function createPassportClient(): Client{
    $clientRepository = new ClientRepository();
    $client = $clientRepository->create(null, "Password Grant Clinet", 'localhost', false, true);

    return $client;
  }


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
  public function it_can_get_verify_token_model_instance(){
    $verifyToken = Identity::verifyToken();

    $this->assertInstanceOf(Identity::verifyTokenModel(), $verifyToken);
  }


  /**
   * @test
   * 
   * @group identity
   * @return void
   */
  public function it_can_get_supported_roles(){
    foreach($this->supportedRoles as $roleName){
      $method = 'getRoleFor' . $roleName;
      $role = forward_static_call([Identity::class, $method], []);

      $this->assertInstanceOf(Identity::roleModel(), $role);
      $this->assertEquals($role->name, $roleName);
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
    $role = Identity::role();

    foreach ($this->supportedRoles as $roleName) {
      $method = 'getRoleIdFor' . $roleName;
      $roleId = forward_static_call([Identity::class, $method], []);

      $role = $role::where('name', $roleName)->first();
      $this->assertEquals($role->id, $roleId);
    }
  }


  /**
   * @test
   * 
   * @group identity
   * @return void
   */
  public function it_can_get_create_user(){
    $this->supportedRoles(function($roleId){
      $userFactory = factory(Identity::userModel())->make()->makeVisible('password');
      $user = Identity::createUser($userFactory->toArray(), $roleId, $userFactory['must_verify_email']);

      $this->assertInstanceOf(Identity::userModel(), $user);
    });
  }

  /**
   * @test
   * 
   * @group identity
   * @return void
   */
  public function it_can_get_user_by_email_and_role(){
    $this->supportedRoles(function ($roleId) {
      $user = $this->createUser(null, $roleId);

      $foundUser = Identity::findUserByEmailAndRoleId($user->email, $roleId);

      $this->assertEquals($user['email'], $foundUser->email);
    });
  }

  /**
   * @test
   * 
   * @group identity
   * @group verify_account
   * @return void
   */
  public function it_should_very_account_with_valid_token(){
    $this->supportedRoles(function ($roleId) {
      $user = $this->createUser('must_verify', $roleId);

      $verifyToken = factory(Identity::verifyTokenModel())->create(['user_id' => $user->id]);

      $this->assertEquals($user->must_verify_email, true);
      $this->assertEquals($user->email_verified_at, null);

      Identity::verifyAccount($verifyToken->token);

      $user = Identity::findUserByEmailAndRoleId($user->email, $roleId);

      $this->assertNotEquals($user->email_verified_at, null);
    });
  }


  /**
   * @test
   * 
   * @group identity
   * @group verify_account
   * @return void
   */
  public function it_should_throw_exception_for_expired_token(){
    $this->supportedRoles(function ($roleId) {
      $user = $this->createUser('must_verify', $roleId);

      $verifyToken = factory(Identity::verifyTokenModel())->states('expired')
        ->create(['user_id' => $user->id]);

      $this->assertEquals($user->must_verify_email, true);
      $this->assertEquals($user->email_verified_at, null);

      $this->expectException(InvalidTokenException::class);
      Identity::verifyAccount($verifyToken->token);
    });
  }

  /**
   * @test
   * 
   * @group identity
   * @group reset_password
   * @return void
   */
  public function it_should_reset_password_valid_token(){
    $this->supportedRoles(function ($roleId) {
      $user = $this->createUser(null, $roleId);

      $verifyToken = factory(Identity::verifyTokenModel())
        ->states('password')
        ->create(['user_id' => $user->id]);

      Identity::resetPassword($verifyToken->token, 'secret2020');

      $user = Identity::findUserByEmailAndRoleId($user->email, $roleId);

      $this->assertTrue(Hash::check('secret2020', $user->password));
    });
  }


  /**
   * @test 
   * 
   * @group identity
   * @group verify_token
   * @return void
   */
  public function it_should_create_email_verify_token_for_user(){
    $this->supportedRoles(function ($roleId) {
      $user = $this->createUser('must_verify', $roleId);
      $attribute = factory(Identity::verifyTokenModel())->make()->toArray();

      $verifyToken = Identity::createVerifyToken($attribute, $user->id);

      $this->assertEquals($verifyToken->token, $attribute['token']);
      $this->assertEquals($verifyToken->used_for, Identity::verifyTokenModel()::EMAIL);
    });
  }

  /**
   * @test 
   * 
   * @group identity
   * @group verify_token
   * @return void
   */
  public function it_should_create_password_reset_token_for_user(){
    $this->supportedRoles(function ($roleId) {
      $user = $this->createUser('must_verify', $roleId);
      $attribute = factory(Identity::verifyTokenModel())->states('password')
        ->make()
        ->toArray();

      $verifyToken = Identity::createVerifyToken($attribute, $user->id);

      $this->assertEquals($verifyToken->token, $attribute['token']);
      $this->assertEquals($verifyToken->used_for, Identity::verifyTokenModel()::PASSWORD);
    });
  }

  /**
   * @test 
   * 
   * @group identity
   * @group verify_token
   * @return void
   */
  public function it_can_revoke_verify_tokens_for_user(){
    $this->supportedRoles(function ($roleId) {
      $user = $this->createUser('must_verify', $roleId);
      $tokens = factory(Identity::verifyTokenModel(), 10)->create(['user_id' => $user->id]);

      Identity::revokeVerifyTokensFor($user->id);

      $this->expectException(InvalidTokenException::class);
      $verifyToken = $tokens->random();
      Identity::verifyAccount($verifyToken->token);
    });
  }

  /**
   * @test 
   * 
   * @group identity
   * @group verify_token
   * @return void
   */
  public function it_can_revoke_verify_token(){
    $tokens = factory(Identity::verifyTokenModel(), 10)->create();

    $verifyToken = $tokens->random();

    Identity::revokeVerifyToken($verifyToken->token);

    $this->expectException(InvalidTokenException::class);
    Identity::verifyAccount($verifyToken->token);
  }

  /**
   * @unsolved
   * 
   * @group identity
   * @group identity_passport
   * @return void
   */
  public function it_can_issue_an_access_token(){
    $client = $this->createPassportClient();
    $this->supportedRoles(function($roleId) use ($client){
      $user = $this->createUser(null, $roleId);

      $data = [
        'user_id' => $user->id,
        "client_id" => $client->id,
        "client_secret" => $client->secret,
        "email" => $user->email,
        "password" => 'secret',
      ];

      $response = Identity::createAccessToken($data);
      $this->assertArrayHasKey('access_token', $response);
    });
  }
}
