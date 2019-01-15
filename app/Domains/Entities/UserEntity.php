<?php

namespace App\Domains\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEntity extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'sub',
    ];
    protected $hidden = [
        'remember_token',
    ];
    protected $dates = ['deleted_at'];
    public $searchColumns = [
        'name',
        'email'
    ];

    public function projectEntities()
    {
        return $this->hasMany(
            'App\Domains\Entities\ProjectEntity',
            'user_id',
            'key'
        );
    }
}
