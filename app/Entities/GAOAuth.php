<?php

namespace App\Entities;

class GAOAuth extends Entity
{
    protected $table = 'ga_oauth';

    public function sites()
    {
        return $this->belongsToMany('App\Entities\Site');
    }
}
