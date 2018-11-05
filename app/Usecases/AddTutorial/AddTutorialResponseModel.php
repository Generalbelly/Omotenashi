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
    public $url;

    /**
     * @var string
     */
    public $site_id;

    public function __construct(array $attributes)
    {
        $this->id = $attributes['id'];
        $this->name = $attributes['name'];
        $this->description = $attributes['description'];
        $this->steps = $attributes['steps'];
        $this->url = $attributes['url'];
        $this->site_id = $attributes['site_id'];
    }

}