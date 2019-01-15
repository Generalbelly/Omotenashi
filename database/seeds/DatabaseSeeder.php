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
        factory(App\Domains\Entities\UserEntity::class, 20)->create()->each(function ($userEntity) {
            $projectEntity = factory(App\Domains\Entities\ProjectEntity::class)->make();
            $tutorialEntity = factory(App\Domains\Entities\TutorialEntity::class)->make();
            $whitelistedDomainEntity = factory(App\Domains\Entities\WhitelistedDomainEntity::class)->make();
            $userEntity->projectEntities()->save($projectEntity);
            $projectEntity->tutorialEntities()->save($tutorialEntity);
            $projectEntity->whitelistedDomainEntities()->save($whitelistedDomainEntity);
        });
    }
}
