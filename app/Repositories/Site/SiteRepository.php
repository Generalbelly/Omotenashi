<?php

namespace App\Repositories\Site;

use App\Entities\Site;

class SiteRepository implements SiteRepositoryContract
{

    public function find(string $id)
    {
        return Site::find($id);
    }

    public function findAll()
    {
        return Site::all();
    }

    public function create(array $attributes)
    {
        $tutorial = new Site;
        $tutorial->save($attributes);
        return $tutorial;
    }

    public function update(string $id, array $attributes)
    {
        $tutorial = $this->find($id);
        $tutorial->save($attributes);
        return $tutorial;
    }

    public function delete(string $id)
    {
        $tutorial = $this->find($id);
        $tutorial->delete();
        return $tutorial;
    }

}