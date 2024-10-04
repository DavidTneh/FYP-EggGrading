<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaccinationPlan extends Model
{
    protected $table = 'vaccinationPlan';
    protected $primaryKey = 'vaccinationPlanID';

    public function vaccinationType()
    {
        return $this->belongsTo(VaccinationType::class, 'vaccinationTypeID');
    }
}
