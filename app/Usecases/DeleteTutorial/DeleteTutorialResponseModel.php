<?php

namespace App\Usecases\DeleteTutorial;

class DeleteTutorialResponseModel {

    public $id;

    public function __construct($attributes)
    {
        $this->id = $attributes['id'];
    }
}