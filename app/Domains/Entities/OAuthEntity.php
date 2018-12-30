<?php

namespace App\Domains\Entities;

class OAuthEntity extends Entity
{
    protected $table = 'oauth';

    public function projectEntities()
    {
        return $this->belongsToMany('App\Domains\Entities\ProjectEntity');
    }

    public function userEntity()
    {
        return $this->belongsTo('App\Domains\Entities\UserEntity');
    }
}
