<?php

namespace App\Domains\Entities;

class ProjectEntity extends Entity
{
    protected $table = 'projects';
    protected $fillable = [
        'name',
        'domain',
        'user_id',
    ];

    public $searchColumns = ['name', 'domain'];

    public function user()
    {
        return $this->belongsTo('App\Domains\Entities\UserEntity');
    }

    public function oauths()
    {
        return $this->belongsToMany('App\Domains\Entities\OAuthEntity');
    }

    public function tutorials()
    {
        return $this->hasMany('App\Domains\Entities\Tutorials');
    }
}
