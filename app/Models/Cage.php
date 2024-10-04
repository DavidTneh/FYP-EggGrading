<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cage extends Model
{
    protected $table = 'cage';
    protected $primaryKey = 'cageID';

    public function chickens()
    {
        return $this->hasMany(Chicken::class, 'cageID');
    }
}
