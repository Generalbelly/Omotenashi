<?php

namespace App\Usecases\RedirectOAuth;

class RedirectOAuthResponseModel {

    /** @var string */
    public $url;

    /** @var string */
    public $state;

    public function __construct(array $attributes)
    {
        $this->url = $attributes['url'];
        $this->state = $attributes['state'];
    }

}