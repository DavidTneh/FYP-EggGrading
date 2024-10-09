<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class CageSchedule extends Eloquent
{
    protected $connection = 'mongodb';
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
