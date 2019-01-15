<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Domains\Entities\UserEntity::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'sub' => $faker->uuid,
        'key' => $faker->uuid,
        'email' => $faker->unique()->safeEmail,
        'remember_token' => str_random(10),
    ];
});
