<?php

namespace App\Entities;

class Tutorial extends Entity
{
    protected $table = 'tutorials';

    public function site()
    {
        return $this->belongsTo('App\Entities\Site');
    }
}
