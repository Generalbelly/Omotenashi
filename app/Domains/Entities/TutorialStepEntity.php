<?php

namespace App\Domains\Entities;

class TutorialStepEntity extends Entity
{
    protected $table = 'tutorial_steps';
    protected $fillable = [
        'path',
        'parameters',
        'type',
        'trigger',
        'selector',
        'content',
        'tutorial_id',
    ];
    protected $casts = [
        'path' => 'array',
        'parameters' => 'array',
        'trigger' => 'array',
    ];
    protected $appends = ['query'];

    public function tutorialEntity()
    {
        return $this->belongsTo(
            'App\Domains\Entities\TutorialEntity',
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
}
