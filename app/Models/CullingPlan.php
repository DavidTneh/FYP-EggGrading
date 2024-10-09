<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CullingPlan extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'cullingPlan';
    protected $primaryKey = 'cullingPlanID';
}
