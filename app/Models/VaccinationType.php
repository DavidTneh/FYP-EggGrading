<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class VaccinationType extends Model
{
    protected $table = 'vaccinationtype';
    protected $primaryKey = 'vaccinationtypeID';

    public function vaccinationPlans()
    {
        return $this->hasMany(VaccinationPlan::class, 'vaccinationtypeID');
    }
}
