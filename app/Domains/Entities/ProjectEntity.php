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
        'tutorial_settings',
    ];

    public $searchColumns = ['name', 'domain'];

    protected $casts = [
        'tutorial_settings' => 'array',
    ];

    public function userEntity()
    {
        return $this->belongsTo('App\Domains\Entities\UserEntity');
    }

    public function oauthEntities()
    {
        return $this->hasMany(
            'App\Domains\Entities\OAuthEntity',
            'project_id',
            'id'
        );
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

    public function googleAnalyticsPropertyEntities()
    {
        return $this->hasMany(
            'App\Domains\Entities\GoogleAnalyticsPropertyEntity',
            'project_id',
            'id'
        );
    }
}
