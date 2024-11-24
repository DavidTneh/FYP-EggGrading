<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedingPlan extends Model
{
    protected $table = 'feedingplan'; // Ensure this matches the actual table name
    protected $primaryKey = 'feedingplanID';

    // Specify the fillable fields to allow mass assignment
    protected $fillable = [
        'time',
        'frequency',
        'is_repeating', // Updated from 'repeat' to 'is_repeating'
    ];

    // Define any relationships if applicable (e.g., tasks associated with the feeding plan)
    public function tasks()
    {
        return $this->hasMany(TaskScheduling::class, 'feedingplanID', 'feedingplanID');
    }
}
