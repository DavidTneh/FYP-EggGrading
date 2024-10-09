<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Chicken extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'chicken';
    protected $primaryKey = 'chickenID';

    public function breed()
    {
        return $this->belongsTo(ChickenBreeds::class, 'breedID');
    }

    public function cage()
    {
        return $this->belongsTo(Cage::class, 'cageID');
    }
}
