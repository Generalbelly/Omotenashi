<?php

namespace App\Domain\Entities;

class GA extends Entity
{
    protected $table = 'gas';

    public function projcects()
    {
        return $this->belongsToMany('App\Domain\Entities\Site');
    }
}
