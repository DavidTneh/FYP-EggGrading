<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egg extends Model
{
    // Define the table name if it's not the default 'eggs'
    protected $table = 'eggs';

    // Enable mass assignment for these attributes
    protected $fillable = [
        'eggGradeID',      // Assuming 'gradeID' is the column in your table
        'type',
        'description',
        'cageID',
    ];

    // Relationship with the Grade model
    public function eggGrade()
    {
        return $this->belongsTo(EggGrade::class, 'eggGradeID');
    }
}
