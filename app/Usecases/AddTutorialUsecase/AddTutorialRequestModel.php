<?php

namespace App\Usecases\AddTutorialUsecase;

class AddTutorialRequestModel {

    /**
     * @var string
     */
    public $domain;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $steps;

    /**
     * @var string
     */
    public $path;

    /**
     * @var string
     */
    public $sub;

    public function __construct(array $attributes)
    {
        $this->domain = $attributes['domain'];
        $this->name = $attributes['name'];
        $this->description = $attributes['description'];
        $this->steps = $attributes['steps'];
        $this->path = $attributes['path'];
        $this->sub = $attributes['sub'];
    }

}
