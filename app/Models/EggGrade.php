<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class EggGrade extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'eggGrade';
    protected $primaryKey = 'eggGradeID';
}
