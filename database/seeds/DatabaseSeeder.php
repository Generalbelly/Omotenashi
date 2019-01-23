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
                    'domain' => 'silos.com',
                ]);
                $tutorialEntity = factory(App\Domains\Entities\TutorialEntity::class)->make([
                    'path' => '/',
                    'steps' => [],
                ]);
                $whitelistedDomainEntity = factory(App\Domains\Entities\WhitelistedDomainEntity::class)->make([
                    'protocol' => 'http',
                    'domain' => 'docker.www.data-silos.com',
                    'project_id' => $projectEntity->id,
                ]);
                $userEntity->sub = 'auth0|5bc9e49fc7d2f35b924027ce'; // auth0
                $userEntity->email = 'nobuyoshi.shimmen@gmail.com';
                $userEntity->name = 'Nobu';
                $userEntity->save();
            } else {
                $projectEntity = factory(App\Domains\Entities\ProjectEntity::class)->make();
                $tutorialEntity = factory(App\Domains\Entities\TutorialEntity::class)->make();
                $whitelistedDomainEntity = factory(App\Domains\Entities\WhitelistedDomainEntity::class)->make();
            }
            $userEntity->projectEntities()->save($projectEntity);
            $projectEntity->tutorialEntities()->save($tutorialEntity);
            $projectEntity->whitelistedDomainEntities()->save($whitelistedDomainEntity);
        });
    }
}
