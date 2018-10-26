<?php

namespace App\Usecases\CreateTutorialUsecase;

use Log;

class CreateTutorialRequest {

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

    public function __construct(array $attributes)
    {
        Log::error($attributes);
        $this->name = $attributes['name'];
        $this->description = $attributes['description'];
        $this->steps = $attributes['steps'];
        $this->path = $attributes['path'];
        Log::error($this->name);
    }

}
