<?php

namespace App\Domains\Entities;

class OAuthEntity extends Entity
{
    protected $table = 'oauth';

    const GOOGLE_ANALYTICS = 'google_analytics';

    public function projectEntity()
    {
        return $this->belongsTo('App\Domains\Entities\ProjectEntity');
    }

    public function userEntity()
    {
        return $this->belongsTo('App\Domains\Entities\UserEntity');
    }
}
