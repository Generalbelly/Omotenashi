<?php

namespace App\Domains\Entities\Observers;

use Ramsey\Uuid\Uuid;

class EntityObserver
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