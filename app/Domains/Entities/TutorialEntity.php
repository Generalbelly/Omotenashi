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
        'parameters',
        'project_id',
        'last_time_used_at',
    ];
    public $searchColumns = [
        'name',
        'description',
    ];
    protected $casts = [
        'steps' => 'array',
        'path' => 'array',
        'parameters' => 'array',
        'last_time_used_at' => 'array',
    ];

//    protected $dates = [
//        'last_time_used_at',
//    ];
    protected $appends = ['query'];

    public function projectEntity()
    {
        return $this->belongsTo(
            'App\Domains\Entities\ProjectEntity',
            'project_id',
            'id'
        );
    }

    public function getQueryAttribute()
    {
        $query = '';
        foreach(json_decode($this->attributes['parameters'], true) as $index => $parameter) {
            $query .= $index === 0 ? '?' : '&';
            $query .= sprintf("%s=%s", $parameter['key'], $parameter['value']);
        };
        return $query;
    }

    static public function generateRegex($pathValue)
    {
        return '/'.str_replace('/', '\/', $pathValue).'/';
    }

}
