<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class TaskScheduling extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'taskScheduling';
    protected $primaryKey = 'taskSchedulingID';
}
