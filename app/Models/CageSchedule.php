<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CageSchedule extends Model
{
    protected $table = 'cageSchedule';
    protected $primaryKey = 'cageScheduleID';

    public function cage()
    {
        return $this->belongsTo(Cage::class, 'cageID');
    }

    public function schedule()
    {
        return $this->belongsTo(TaskScheduling::class, 'scheduleID');
    }
}
