<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chicken extends Model
{
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
