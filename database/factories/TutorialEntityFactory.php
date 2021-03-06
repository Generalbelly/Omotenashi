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

$factory->define(App\Domains\Entities\TutorialEntity::class, function (Faker $faker) {
    $path = [
        "deepness" => 0,
        "value" => "/",
        "regex" => false
    ];
    return [
        'id' => $faker->uuid,
        'name' => $faker->name,
        'description' => $faker->realText(),
        'path' => $path,
        'parameters' => [],
        'settings' => [],
        'last_time_used_at' => [
            $path['value'] => null
        ],
    ];
});
