<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Identity\Entities\User;

$factory->define(User::class, function (Faker $faker) {
  return [
    'email' => $faker->safeEmail,
    'password' => 'secret',
    'must_verify_email' => true,
    'email_verified_at' => $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now'),
    'profile' => [
      'first_name' => $faker->firstName,
      'last_name' => $faker->lastName,
    ],
    'created_at' => $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now'),
    'updated_at' => $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now'),
  ];
});


$factory->state(User::class, 'must_verify', [
  'must_verify_email' => true,
  'email_verified_at' => null,
]);
