<?php

namespace App\Domain\Entities;

class GAOauth extends Entity
{
    protected $table = 'ga_oauth';

    public function sites()
    {
        return $this->belongsToMany('App\Domain\Entities\Site');
    }
}
