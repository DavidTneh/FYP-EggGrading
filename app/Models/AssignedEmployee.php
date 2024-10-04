<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedEmployee extends Model
{
    protected $table = 'assignedEmployee';
    protected $primaryKey = 'assignedEmployeeID';

    public function task()
    {
        return $this->belongsTo(TaskScheduling::class, 'taskSchedulingID');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
