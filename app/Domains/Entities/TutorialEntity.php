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
        'last_time_used_at',
    ];
    public $searchColumns = [
        'name',
        'description',
        'path'
    ];
    protected $casts = [
        'steps' => 'array',
    ];

    protected $dates = [
        'last_time_used_at',
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
