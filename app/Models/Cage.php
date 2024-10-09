<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Cage extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'cage';
    protected $primaryKey = 'cageID';

    public function chickens()
    {
        return $this->hasMany(Chicken::class, 'cageID');
    }
}
