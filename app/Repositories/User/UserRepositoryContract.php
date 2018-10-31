<?php

namespace App\Repositories\User;

interface UserRepositoryContract {

    /**
     * @param string $id
     * @return \App\Domains\Entities\UserEntity
     */
    public function findById(string $id);

    /**
     * @param string $sub
     * @return \App\Domains\Entities\UserEntity
     */
    public function findBySub(string $sub);

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll();

    /**
     * @param array $attributes;
     * @return \App\Domains\Entities\UserEntity
     */
    public function add(array $attributes);

    /**
     * @param string $id;
     * @param array $attributes;
     * @return \App\Domains\Entities\UserEntity
     */
    public function update(string $id, array $attributes);

    /**
     * @param string $id;
     * @return \App\Domains\Entities\UserEntity
     */
    public function delete(string $id);

}