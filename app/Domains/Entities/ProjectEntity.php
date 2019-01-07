<?php

namespace App\Domains\Entities;

class ProjectEntity extends Entity
{
    protected $table = 'projects';
    protected $fillable = [
        'name',
        'domain',
        'protocol',
        'user_id',
    ];

    public $searchColumns = ['name', 'domain'];

    public function userEntity()
    {
        return $this->belongsTo('App\Domains\Entities\UserEntity');
    }

    public function oauthEntities()
    {
        return $this->belongsToMany('App\Domains\Entities\OAuthEntity');
    }

    public function tutorialEntities()
    {
        return $this->hasMany(
            'App\Domains\Entities\TutorialEntity',
            'project_id',
            'id'
        );
    }

    public function whitelistedDomainEntities()
    {
        return $this->hasMany(
            'App\Domains\Entities\WhitelistedDomainEntity',
            'project_id',
            'id'
        );
    }
}
