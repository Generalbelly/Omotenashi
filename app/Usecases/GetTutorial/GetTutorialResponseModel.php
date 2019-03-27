<?php

namespace App\Usecases\GetTutorial;

class GetTutorialResponseModel {

    public $tutorial;
    public $property_id;
    public $tutorial_settings;

    public function __construct(array $attributes)
    {
        $this->tutorial = $attributes['tutorial'];
        $this->property_id = $attributes['property_id'];
        $this->tutorial_settings = $attributes['tutorial_settings'];
    }

}