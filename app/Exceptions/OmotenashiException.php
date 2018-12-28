<?php

namespace App\Exceptions;

use Throwable;

interface OmotenashiException extends Throwable {

    public function getType(): string;

}