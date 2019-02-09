<?php

namespace App\Domains\Entities;

class OAuthEntity extends Entity
{
    protected $table = 'oauths';
    protected $fillable = [
        'service',
        'email',
        'refresh_token',
        'access_token',
        'project_id'
    ];

    public function projectEntity()
    {
        return $this->belongsTo('App\Domains\Entities\ProjectEntity');
    }

    public function userEntity()
    {
        return $this->belongsTo('App\Domains\Entities\UserEntity');
    }
}
