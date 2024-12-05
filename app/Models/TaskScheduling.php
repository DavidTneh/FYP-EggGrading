<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskScheduling extends Model
{
    protected $table = 'taskscheduling';
    protected $primaryKey = 'scheduleID';
    protected $fillable = [
        'taskName',
        'taskDescription',
        'collectionPlanID',
        'feedingPlanID',
        'cullingPlanID',
        'collectionStatus', // New field
        'feedingStatus',    // New field
        'cullingStatus',    // New field
        'status',
    ];

    public function collectionPlan()
    {
        return $this->belongsTo(CollectionPlan::class, 'collectionPlanID');
    }

    public function feedingPlan()
    {
        return $this->belongsTo(FeedingPlan::class, 'feedingPlanID');
    }

    public function cullingPlan()
    {
        return $this->belongsTo(CullingPlan::class, 'cullingPlanID');
    }

    public function assignedEmployees()
    {
        return $this->hasMany(AssignedEmployee::class, 'scheduleID');
    }

    public function cageSchedules()
    {
        return $this->hasMany(CageSchedule::class, 'scheduleID');
    }
}
