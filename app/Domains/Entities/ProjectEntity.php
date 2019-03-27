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
        'settings',
    ];

    public $searchColumns = ['name', 'domain'];

    public $casts = [
        'settings' => 'array',
    ];

    public function getTutorialSettingsAttribute()
    {
        return json_decode($this->attributes['settings'], true);
    }

    public function setTutorialSettingsAttribute($value)
    {
        $this->attributes['settings'] = json_encode($value);
    }

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
