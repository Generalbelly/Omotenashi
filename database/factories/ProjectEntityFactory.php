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

$factory->define(App\Domains\Entities\ProjectEntity::class, function (Faker $faker) {
    $tutorialSettings = [
        "distribution_ratio" => "random",
        "only_once" => true,
        "only_once_duration" => "forever",
    ];
    return [
        'id' => $faker->uuid,
        'name' => $faker->name,
        'domain' => $faker->domainName,
        'tutorial_settings' => $tutorialSettings,
        'protocol' => 'https',
    ];
});