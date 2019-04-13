<?php

namespace App\Domains\Entities;

class TutorialPathEntity extends Entity
{
    const OPERATOR_REGEXP = 'regex';
    const OPERATOR_EQUAL = 'equals';
    const OPERATOR_FORWARD_MATCH = 'forward';
    const OPERATOR_BACKWARD_MATCH = 'backward';

    protected $table = 'tutorial_paths';
    protected $primaryKey = ['ancestor', 'descendant'];
    protected $fillable = [
        'ancestor',
        'descendant',
    ];

}
