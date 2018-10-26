<?php

namespace App\Repositories\Tutorial;

use App\Entities\Tutorial;

class TutorialRepository implements TutorialRepositoryContract
{

    public function find(string $id)
    {
        return Tutorial::find($id);
    }

    public function findAll()
    {
        return Tutorial::all();
    }

    public function create(array $attributes)
    {
        $tutorial = new Tutorial;
        $tutorial->name = $attributes['name'];
        $tutorial->description = $attributes['description'];
        $tutorial->steps = $attributes['steps'];
        $tutorial->path = $attributes['path'];
        $tutorial->site_id = $attributes['site_id'];
        $tutorial->save($attributes);
        return $tutorial;
    }

    public function update(string $id, array $attributes)
    {
        $tutorial = $this->find($id);
        $tutorial->name = $attributes['name'];
        $tutorial->description = $attributes['description'];
        $tutorial->steps = $attributes['steps'];
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