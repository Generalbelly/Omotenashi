<?php

namespace App\Domains\Entities\Exceptions;

use Exception;

class ProjectNotFound extends Exception implements OmotenashiException {

    private $type = 'ProjectNotFound';

    public function __construct(string $domain)
    {
        parent::__construct("We couldn't find a project with the whitelisted domain '".$domain."'.", 404);
    }

    public function getType(): string
    {
        return $this->type;
    }

}