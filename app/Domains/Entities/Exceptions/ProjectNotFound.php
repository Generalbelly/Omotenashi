<?php

namespace App\Domains\Entities\Exceptions;

use Exception;

class ProjectNotFound extends Exception implements OmotenashiException {

    private $type = 'ProjectNotFound';

    public function __construct(string $domain)
    {
        parent::__construct("Project with the domain '".$domain."' doesn't exist yet.", 404);
    }

    public function getType(): string
    {
        return $this->type;
    }

}