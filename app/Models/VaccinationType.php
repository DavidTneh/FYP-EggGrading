<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class VaccinationType extends Model
{
    protected $table = 'vaccinationType';
    protected $primaryKey = 'vaccinationTypeID';

    public function vaccinationPlans()
    {
        return $this->hasMany(VaccinationPlan::class, 'vaccinationTypeID');
    }
}
