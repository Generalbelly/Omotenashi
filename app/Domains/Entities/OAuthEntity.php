<?php

namespace App\Domains\Entities;

class OAuthEntity extends Entity
{
    protected $table = 'oauth';

    public function projectEntity()
    {
        return $this->belongsTo('App\Domains\Entities\ProjectEntity');
    }

    public function userEntity()
    {
        return $this->belongsTo('App\Domains\Entities\UserEntity');
    }
}
