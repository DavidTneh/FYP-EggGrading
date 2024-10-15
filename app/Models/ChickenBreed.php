<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChickenBreeds extends Model
{
    protected $table = 'chickenBreeds';
    protected $primaryKey = 'breedID';

    public function chickens()
    {
        return $this->hasMany(Chicken::class, 'breedID');
    }
}
