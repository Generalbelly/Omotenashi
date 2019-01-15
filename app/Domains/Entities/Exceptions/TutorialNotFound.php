<?php

namespace App\Domains\Entities\Exceptions;

use Exception;

class TutorialNotFound extends Exception implements OmotenashiException {

    private $type = 'TutorialNotFound';

    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, 404, $previous);
    }

    public function getType(): string
    {
        return $this->type;
    }

}