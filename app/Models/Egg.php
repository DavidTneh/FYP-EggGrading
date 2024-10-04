<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egg extends Model
{
    protected $table = 'eggs';
    protected $primaryKey = 'eggID';

    public function eggGrade()
    {
        return $this->belongsTo(EggGrade::class, 'eggGradeID');
    }
}
