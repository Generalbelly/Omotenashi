<?php

namespace App\Repositories\Site;

interface SiteRepositoryContract {

    /**
     * @param string $id
     * @return \App\Domains\Entities\SiteEntity
     */
    public function findById(string $id);

    /**
     * @param string $domain
     * @return \App\Domains\Entities\SiteEntity
     */
    public function findByDomain(string $domain);

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll();

    /**
     * @param array $attributes;
     * @return \App\Domains\Entities\SiteEntity
     */
    public function add(array $attributes);

    /**
     * @param string $id;
     * @param array $attributes;
     * @return \App\Domains\Entities\SiteEntity
     */
    public function update(string $id, array $attributes);

    /**
     * @param string $id;
     * @return \App\Domains\Entities\SiteEntity
     */
    public function delete(string $id);

}