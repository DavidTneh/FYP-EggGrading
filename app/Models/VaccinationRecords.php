<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinationRecords extends Model
{
    // Table associated with the model
    protected $table = 'vaccination_records';

    // Primary key of the table
    protected $primaryKey = 'recordID';

    // The attributes that are mass assignable
    protected $fillable = [
        'chickenID',
        'vaccinationplanID',
        'cageID', // Add cageID
        'date_administered',
        'administered_by',
        'status',
        'notes',
    ];


    // Relationships

    /**
     * Get the chicken associated with this vaccination record.
     */
    public function chicken()
    {
        return $this->belongsTo(Chicken::class, 'chickenID', 'chickenID');
    }
    
    /**
     * Get the vaccination associated with this vaccination record.
     */
    public function vaccinationplan()
    {
        return $this->belongsTo(VaccinationPlan::class, 'vaccinationplanID', 'vaccinationplanID');
    }

    /**
     * Get the employee who administered the vaccination.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'administered_by', 'userID');
    }
}
