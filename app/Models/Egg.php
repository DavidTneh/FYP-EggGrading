<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Egg extends Eloquent
{
    protected $connection = 'mongodb';
    // Define the table name if it's not the default 'eggs'
    protected $table = 'eggs';

    // Specify the primary key, assuming it's 'eggsID' in your table
    protected $primaryKey = 'eggsID';

    // Enable timestamps
    public $timestamps = true;

    // Allow mass assignment for these attributes
    protected $fillable = [
        'eggGradeID',
        'type',
        'description',
        'cageID',
        'created_at',
    ];

    // Relationship with the Grade model
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
