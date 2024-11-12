<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationPlan extends Model
{
    protected $table = 'vaccinationPlan';
    protected $primaryKey = 'vaccinationPlanID';

    protected $fillable = [
        'vaccinationtypeID',
        'vaccinationPerChicken',
        'cageID',
        'totalVaccinationRequired',
        'date'
    ];

    // Relationship with VaccinationType
    public function vaccinationType()
    {
        return $this->belongsTo(VaccinationType::class, 'vaccinationtypeID');
    }

    // Relationship with Cage
    public function cage()
    {
        return $this->belongsTo(Cage::class, 'cageID');
    }
}
