<?php

namespace App\Domains\Entities;

class TutorialStepEntity extends Entity
{
    protected $table = 'tutorial_steps';
    protected $fillable = [
        'target',
        'value',
        'config',
        'tutorial_id',
    ];
    protected $casts = [
        'value' => 'array',
        'config' => 'array',
    ];

    public function tutorialEntity()
    {
        return $this->belongsTo(
            'App\Domains\Entities\TutorialEntity',
            'tutorial_id',
            'id'
        );
    }

}
