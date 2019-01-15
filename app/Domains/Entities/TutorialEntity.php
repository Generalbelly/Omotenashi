<?php

namespace App\Domains\Entities;

class TutorialEntity extends Entity
{
    protected $table = 'tutorials';
    protected $fillable = [
        'name',
        'description',
        'steps',
        'path',
        'query',
        'project_id',
    ];
    public $searchColumns = [
        'name',
        'description',
        'path'
    ];
    protected $casts = [
        'steps' => 'array',
    ];

    public function projectEntity()
    {
        return $this->belongsTo(
            'App\Domains\Entities\ProjectEntity',
            'project_id',
            'id'
        );
    }

}
