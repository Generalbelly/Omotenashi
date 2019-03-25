<?php

namespace App\Usecases\ListTutorials;

class ListTutorialsResponseModel {

    public $total;
    public $start;
    public $end;
    public $projectEntity;
    public $tutorialEntities;

    public function __construct(array $attributes)
    {
        $this->total = $attributes['total'];
        $this->start = $attributes['start'];
        $this->end = $attributes['end'];
        $this->projectEntity = $attributes['projectEntity'];
        $this->tutorialEntities = $attributes['entities'];
    }

}