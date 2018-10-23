<?php

namespace App\Entities;

class Site extends Entity
{
    protected $table = 'sites';

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function gaOauths()
    {
        return $this->belongsToMany('App\Entities\GAOAuth');
    }

    public function tutorials()
    {
        return $this->hasMany('App\Entities\Tutorials');
    }
}
