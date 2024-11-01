<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FeedingPlan extends Model
{
    protected $table = 'feedingPlan';
    protected $primaryKey = 'feedingPlanID';

    protected $fillable = [
        'time',
        'frequency',
        'repeat',
    ];
}

