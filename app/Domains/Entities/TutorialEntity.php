<?php

namespace App\Domains\Entities;

class TutorialEntity extends Entity
{
    protected $table = 'tutorials';
    protected $fillable = [
        'name',
        'description',
        'steps',
        'url',
        'path',
        'query',
        'project_id',
    ];
    public $searchColumns = [
        'name',
        'description',
        'url',
        'path'
    ];

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
        return $this->belongsTo('App\Domains\Entities\ProjectEntity');
    }
}
