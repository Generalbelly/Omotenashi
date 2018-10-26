<?php

namespace App\Usecases\CreateTutorialUsecase;

class CreateTutorialResponse {

    /**
     * @var string
     */
    public $id;

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
    public $site_id;

    public function __construct(array $attributes)
    {
        $this->name = $attributes['name'];
        $this->description = $attributes['description'];
        $this->steps = $attributes['steps'];
        $this->path = $attributes['path'];
        $this->site_id = $attributes['site_id'];
    }

}