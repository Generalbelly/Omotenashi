<?php

namespace App\Domains\Entities;

class TutorialEntity extends Entity
{
    protected $table = 'tutorials';
    protected $fillable = [
        'operator',
        'depth',
        'name',
        'path',
        'parameters',
        'description',
        'settings',
        'is_active',
        'last_time_used_at',
        'project_id',
    ];

    public $searchColumns = [
        'name',
        'path',
        'description',
    ];
    protected $casts = [
        'parameters' => 'array',
        'last_time_used_at' => 'array',
        'settings' => 'array',
    ];

    protected $appends = [
        'query',
    ];

    public function projectEntity()
    {
        return $this->belongsTo(
            'App\Domains\Entities\ProjectEntity',
            'project_id',
            'id'
        );
    }

    public function tutorialEntities()
    {
        return $this->hasMany(
            'App\Domains\Entities\TutorialStepEntity',
            'tutorial_id',
            'id'
        );
    }

    public function getQueryAttribute()
    {
        $query = '';
        foreach(json_decode($this->attributes['parameters'], true) as $index => $parameter) {
            $query .= $index === 0 ? '' : '&';
            $query .= sprintf("%s=%s", $parameter['key'], $parameter['value']);
        };
        return $query;
    }

    static public function generateRegex($pathValue)
    {
        return '/'.str_replace('/', '\/', $pathValue).'/';
    }

}
