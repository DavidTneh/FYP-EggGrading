<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionPlan extends Model
{
    protected $table = 'collectionplan';
    protected $primaryKey = 'collectionplanID';

    protected $fillable = [
        'time',
        'frequency',
        'is_repeating',
    ];

}
