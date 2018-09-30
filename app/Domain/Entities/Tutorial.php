<?php

namespace App\Domain\Entities;

class Tutorial extends Entity
{
    protected $table = 'tutorials';

    public function site()
    {
        return $this->belongsTo('App\Domain\Entities\Site');
    }
}
