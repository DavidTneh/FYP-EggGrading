<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VaccinationType extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'vaccinationType';
    protected $primaryKey = 'vaccinationTypeID';

    public function vaccinationPlans()
    {
        return $this->hasMany(VaccinationPlan::class, 'vaccinationTypeID');
    }
}
