<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Domains\Entities\UserEntity::class, 20)->create()->each(function ($userEntity, $key) {
            if ($key === 0) {
                $projectEntity = factory(App\Domains\Entities\ProjectEntity::class)->make([
                    'name' => 'silo',
                    'protocol' => 'http',
                    'domain' => 'omotenashi-customer-site.com',
                ]);
//                $tutorialEntity = factory(App\Domains\Entities\TutorialEntity::class)->make();
                $userEntity->sub = 'auth0|5bc9e49fc7d2f35b924027ce'; // auth0
                $userEntity->email = 'nobuyoshi.shimmen@gmail.com';
                $userEntity->name = 'Nobu';
                $userEntity->key = 'fa307526-3d9d-4c9b-ac2a-e5e1186f1359';
                $userEntity->save();

                $userEntity->projectEntities()->save($projectEntity);
//                $projectEntity->tutorialEntities()->save($tutorialEntity);
            } else {
                $projectEntity = factory(App\Domains\Entities\ProjectEntity::class)->make();
//                $tutorialEntity = factory(App\Domains\Entities\TutorialEntity::class)->make();

                $userEntity->projectEntities()->save($projectEntity);
//                $projectEntity->tutorialEntities()->save($tutorialEntity);
            }
        });
    }
}
