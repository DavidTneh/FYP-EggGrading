<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Egg extends Model
{
    protected $table = 'eggs';
    protected $primaryKey = 'eggID';

    // Enable mass assignment for these attributes
    protected $fillable = [
        'eggGradeID',      // Assuming 'gradeID' is the column in your table
        'type',
        'description',
        'cageID',
        'created_at',
    ];

    public function eggGrade()
    {
        return $this->belongsTo(EggGrade::class, 'eggGradeID');
    }

    // Relationship with the Cage model
    public function cage()
    {
        return $this->belongsTo(Cage::class, 'cageID');
    }
}
