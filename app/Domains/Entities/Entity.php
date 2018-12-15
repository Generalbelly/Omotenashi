<?php

namespace App\Domains\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $searchColumns = ['id'];
    public $incrementing = false;
}
