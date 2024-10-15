<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedEmployee extends Model
{
    protected $table = 'assignedEmployee'; // Collection name in MongoDB
    protected $primaryKey = 'assignedEmployeeID'; // MongoDB doesn't use auto-increment IDs like MySQL

    public function task()
    {
        return $this->belongsTo(TaskScheduling::class, 'taskSchedulingID');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
