<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class ChickenBreeds extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'chickenBreeds';
    protected $primaryKey = 'breedID';

    public function chickens()
    {
        return $this->hasMany(Chicken::class, 'breedID');
    }
}
