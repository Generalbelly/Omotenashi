<?php

namespace App\Repositories\Tutorial;

use App\Domains\Entities\TutorialEntity;

class TutorialRepository implements TutorialRepositoryContract
{

    public function findById(string $id)
    {
        return TutorialEntity::find($id);
    }

    public function getAll()
    {
        return TutorialEntity::all();
    }

    public function add(array $attributes)
    {
        $tutorial = new TutorialEntity;
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