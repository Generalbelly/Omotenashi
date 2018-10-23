<?php

namespace App\Entities\Observers;

use App\Entities\Tutorial;

class TutorialObserver extends Observer
{
    public function creating(Tutorial $tutorial)
    {
        $id = $this->generateKey(Tutorial::class, 'id');
        $tutorial->setAttribute('id', $id);
    }
}