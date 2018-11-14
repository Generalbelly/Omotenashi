<?php

namespace App\Domains\Entities;

class SiteEntity extends Entity
{
    protected $table = 'sites';
    protected $fillable = [
        'name',
        'domain',
        'type',
        'user_id',
    ];

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
