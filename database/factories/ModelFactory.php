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
        'nickname' => $faker->lastName,
        'username' => $faker->unique()->lastName,
        'password' => md5('123456'.config('app.key')),
        'role_id' => $faker->randomElement(array(1,2,3)),
        'created_user_id' => 1,
        'updated_user_id' => 1,
        'flag' => 1
    ];
});

/**
 * 生成角色
 */
$factory->define(APP\Role::class, function (Faker\Generator $faker){
    return [
        'role_name' => $faker->randomElement(array('超级管理员','管理员','员工组')),
        'role_auth' => '[*]',
        'flag' => 1
    ];
});

