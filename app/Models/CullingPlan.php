<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CullingPlan extends Model
{
    protected $table = 'cullingplan';
    protected $primaryKey = 'cullingplanID';

    protected $fillable = [
        'eliminateAgeThreshold',
        'reasons',
        'healthStatus',
        'notes',
    ];
}
