<?php

namespace App\Domains\Entities;

class TutorialStepperEntity extends Entity
{
    protected $table = 'tutorials';
    protected $fillable = [
        'path',
        'steps',
        'tutorial_id',
    ];
    public $searchColumns = [
        'path',
    ];
    protected $casts = [
        'steps' => 'array',
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
