<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CageSchedule extends Model
{
    protected $table = 'cageschedule';
    protected $primaryKey = 'cageScheduleID';
    protected $fillable = ['cageID', 'scheduleID'];

    public function cage()
    {
        return $this->belongsTo(Cage::class, 'cageID');
    }

    public function taskScheduling()
    {
        return $this->belongsTo(TaskScheduling::class, 'scheduleID');
    }
}
