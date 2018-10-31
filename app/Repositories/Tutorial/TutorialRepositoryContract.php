<?php

namespace App\Repositories\Tutorial;

interface TutorialRepositoryContract {

    /**
     * @param string $id
     * @return \App\Domains\Entities\TutorialEntity
     */
    public function findById(string $id);

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll();

    /**
     * @param array $attributes;
     * @return \App\Domains\Entities\TutorialEntity
     */
    public function add(array $attributes);

    /**
     * @param string $id;
     * @param array $attributes;
     * @return \App\Domains\Entities\TutorialEntity
     */
    public function update(string $id, array $attributes);

    /**
     * @param string $id;
     * @return \App\Domains\Entities\TutorialEntity
     */
    public function delete(string $id);

}