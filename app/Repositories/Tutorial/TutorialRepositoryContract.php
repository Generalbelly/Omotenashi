<?php

namespace App\Repositories\Tutorial;

interface TutorialRepositoryContract {

    /**
     * @param string $id
     * @return \App\Entities\Tutorial
     */
    public function find(string $id);

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAll();

    /**
     * @param array $attributes;
     * @return \App\Entities\Tutorial
     */
    public function create(array $attributes);

    /**
     * @param string $id;
     * @param array $attributes;
     * @return \App\Entities\Tutorial
     */
    public function update(string $id, array $attributes);

    /**
     * @param string $id;
     * @return \App\Entities\Tutorial
     */
    public function delete(string $id);

}