<?php

namespace App\Usecases\RedirectTutorial;

class RedirectTutorialResponseModel {

    /** @var string */
    public $url;

    public function __construct(array $attributes)
    {
        $this->url = $attributes['url'];
    }

}