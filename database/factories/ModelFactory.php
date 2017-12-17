<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->unique()->name,
        'password' => bcrypt('secret'),
        'flag' => 1,
        'created_user_id' => 1,
        'updated_user_id' => 1,
        'role_id' => mt_rand(1,2)
    ];
});
