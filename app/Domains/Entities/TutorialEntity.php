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
    protected $casts = [
        'steps' => 'array',
    ];

    public function projectEntity()
    {
        return $this->belongsTo('App\Domains\Entities\ProjectEntity');
    }
}
