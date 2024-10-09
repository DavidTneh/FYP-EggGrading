<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class FeedingPlan extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'feedingPlan';
    protected $primaryKey = 'feedingPlanID';
}
