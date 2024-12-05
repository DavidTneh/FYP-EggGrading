<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatusLog extends Model
{
    // Te table associated with the model
    protected $table = 'task_status_logs';
    // Primary key column
    protected $primaryKey = 'task_status_logID';

    // Mass assignable attributes
    protected $fillable = [
        'scheduleID',
        'log_date',
        'collectionStatus',
        'feedingStatus',
        'cullingStatus',
        'status',
    ];

    /**
     * Relationship with TaskScheduling model
     */
    public function taskScheduling()
    {
        return $this->belongsTo(TaskScheduling::class, 'scheduleID', 'scheduleID');
    }

    /**
     * Scope for filtering by date.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDate($query, $date)
    {
        return $query->where('log_date', $date);
    }

    /**
     * Scope for filtering by task schedule ID.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $scheduleID
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySchedule($query, $scheduleID)
    {
        return $query->where('scheduleID', $scheduleID);
    }
}
