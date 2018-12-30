<?php

namespace App\Domains\Entities\Exceptions;

use Throwable;

interface OmotenashiException extends Throwable {

    public function getType(): string;

}