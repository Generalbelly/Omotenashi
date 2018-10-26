<?php

namespace App\Entities;

class Tutorial extends Entity
{
    protected $table = 'tutorials';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'steps' => 'array',
    ];

    public function site()
    {
        return $this->belongsTo('App\Entities\Site');
    }
}
