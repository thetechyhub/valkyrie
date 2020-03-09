<?php

namespace Modules\Admin\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Identity\Repositories\UserRepository;
use Modules\Identity\Repositories\RoleRepository;

class RegisterAdmin extends Command{
  /**
   * The console command name.
   *
   * @var string
   */
  protected $signature = 'register:admin
  {--s|super : Register User With Super Administrator Privileges}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Register User With Administrator Privileges';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct(){
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle(){
    $email = $this->ask('Enter admin email?');
    $first_name = $this->ask('Enter admin first name?');
    $last_name = $this->ask('Enter admin last name?');
    $password = $this->secret('Enter admin password?');
    $confirmPassword = $this->secret('Confirm password?');

    $data = [
      'email' => $email,
      'password' => $password,
      'password_confirmation' => $confirmPassword,
      'profile' => [
        'first_name' => $first_name,
        'last_name' => $last_name
      ]
    ];
    $validator = Validator::make($data, [
      'email' => 'required',
      'password' => 'required|min:6|confirmed',
    ]);

    if ($validator->fails()) {
      $this->error($validator->errors()->first());
      return;
    }


    $roleId = RoleRepository::getAdministratorRoleId();

    if($this->option('super')){
      $roleId = RoleRepository::getSuperAdministratorRoleId();
    }

    $user = UserRepository::create($data, $roleId, false);
    

    if ($user) {
      $this->info('User With Administrator Privileges Has been created.');
    } else {
      $this->error("An error occurred, please try again later");
      return;
    }
  }

  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments(){
    return [
      ['example', InputArgument::REQUIRED, 'An example argument.'],
    ];
  }

  /**
   * Get the console command options.
   *
   * @return array
   */
  protected function getOptions(){
    return [
      ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
    ];
  }
}
