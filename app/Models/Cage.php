<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cage extends Model
{
    protected $table = 'cage';
    protected $primaryKey = 'cageID';

    protected $fillable = [
        'name',
        'size',
        'capacity',
        'type',
        'status',
        'availability'
    ];

    // Define the relationship to Chicken
    public function chickens()
    {
        return $this->hasMany(Chicken::class, 'cageID');
    }

    public function cageschedule()
    {
        return $this->hasMany(CageSchedule::class, 'cageID');
    }
}
