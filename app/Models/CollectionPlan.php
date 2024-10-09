<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class CollectionPlan extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'collectionPlan';
    protected $primaryKey = 'collectionPlanID';
}
