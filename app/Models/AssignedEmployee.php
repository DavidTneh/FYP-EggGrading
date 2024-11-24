<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedEmployee extends Model
{
    protected $table = 'assignedemployee';
    protected $primaryKey = 'assignedID';
    protected $fillable = ['userID', 'scheduleID'];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function taskScheduling()
    {
        return $this->belongsTo(TaskScheduling::class, 'scheduleID');
    }
}
