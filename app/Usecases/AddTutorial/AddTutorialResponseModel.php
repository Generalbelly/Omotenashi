<?php

namespace App\Usecases\AddTutorial;

class AddTutorialResponseModel {

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
     * @var array
     */
    public $parameters;

    /**
     * @var string
     */
    public $project_id;

    public function __construct(array $attributes)
    {
        $this->id = $attributes['id'];
        $this->name = $attributes['name'];
        $this->description = $attributes['description'];
        $this->steps = $attributes['steps'];
        $this->path = $attributes['path'];
        $this->parameters = $attributes['parameters'];
        $this->project_id = $attributes['project_id'];
    }

}