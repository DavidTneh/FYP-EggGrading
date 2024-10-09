<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VaccinationPlan extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'vaccinationPlan';
    protected $primaryKey = 'vaccinationPlanID';

    public function vaccinationType()
    {
        return $this->belongsTo(VaccinationType::class, 'vaccinationTypeID');
    }
}
