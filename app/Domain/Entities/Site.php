<?php

namespace App\Domain\Entities;

class Site extends Entity
{
    protected $table = 'sites';

    public function user()
    {
        return $this->belongsTo('App\Domain\Entities\User');
    }

    public function gases()
    {
        return $this->belongsToMany('App\Domain\Entities\GA');
    }

    public function tutorials()
    {
        return $this->hasMany('App\Domain\Entities\Tutorials');
    }
}
