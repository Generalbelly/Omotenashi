<?php

namespace App\Usecases\GetTutorial;

class GetTutorialResponseModel {

    public $id;
    public $steps;

    public function __construct(array $attributes)
    {
        $this->id = $attributes['id'];
        $this->steps = $attributes['steps'];
    }

}