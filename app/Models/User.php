<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class User extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'user';
    protected $primaryKey = 'userID';

    public function role()
    {
        return $this->belongsTo(Role::class, 'roleID');
    }
}
