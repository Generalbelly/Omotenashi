<?php

namespace App\Domains\Entities;

class TutorialEntity extends Entity
{
    protected $table = 'tutorials';
    protected $fillable = [
        'name',
        'path',
        'description',
        'orders',
        'project_id',
        'last_time_used_at',
    ];
    public $searchColumns = [
        'name',
        'path',
        'description',
    ];
    protected $casts = [
        'path' => 'array',
        'parameters' => 'array',
        'orders' => 'array',
        'last_time_used_at' => 'array',
    ];

    protected $appends = ['query'];

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
