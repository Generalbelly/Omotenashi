<?php

namespace App\Repositories\Site;

use App\Domains\Entities\SiteEntity;

class SiteRepository implements SiteRepositoryContract
{

    /**
     * @param string $id
     * @return \App\Domains\Entities\SiteEntity
     */
    public function findById(string $id)
    {
        return SiteEntity::find($id);
    }

    /**
     * @param string $domain
     * @return \App\Domains\Entities\SiteEntity
     */
    public function findByDomain(string $domain)
    {
        return SiteEntity::where('domain', $domain);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param array $attributes ;
     * @return \App\Domains\Entities\SiteEntity
     */
    public function add(array $attributes)
    {
        // TODO: Implement add() method.
    }

    /**
     * @param string $id ;
     * @param array $attributes ;
     * @return \App\Domains\Entities\SiteEntity
     */
    public function update(string $id, array $attributes)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param string $id ;
     * @return \App\Domains\Entities\SiteEntity
     */
    public function delete(string $id)
    {
        // TODO: Implement delete() method.
    }
}