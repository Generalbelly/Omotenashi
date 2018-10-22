<?php

namespace App\Domain\Entities\Observers;

use Ramsey\Uuid\Uuid;

class Observer
{
    public function generateKey($class, $column)
    {
        do{
            $uuidObject = Uuid::uuid4();
            $uuid = $uuidObject->toString();

            $entity = $class::where($column, $uuid)->first();

        }while($entity != null);

        return $uuid;
    }
}