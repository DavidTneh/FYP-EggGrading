<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Role extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'role';
    protected $primaryKey = 'roleID';

    public function users()
    {
        return $this->hasMany(User::class, 'roleID');
    }
}
