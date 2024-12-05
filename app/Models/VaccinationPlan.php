<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationPlan extends Model
{
    protected $table = 'vaccinationplan';
    protected $primaryKey = 'vaccinationplanID';

    protected $fillable = [
        'vaccinationtypeID',
        'vaccinationPerChicken',
        'ageThreshold',
    ];



    // Relationship with VaccinationType
    public function vaccinationType()
    {
        return $this->belongsTo(VaccinationType::class, 'vaccinationtypeID');
    }

    public function vaccinationRecords()
    {
        return $this->hasMany(VaccinationRecords::class, 'vaccinationplanID','vaccinationplanID');
    }
    
    // Relationship with Cage
    public function cage()
    {
        return $this->belongsTo(Cage::class, 'cageID');
    }
}
