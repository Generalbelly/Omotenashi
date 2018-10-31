<?php

namespace App\Domains\Entities;

class OAuthEntity extends Entity
{
    protected $table = 'oauth';

    public function sites()
    {
        return $this->belongsToMany('App\Domains\Entities\SiteEntity');
    }
}
