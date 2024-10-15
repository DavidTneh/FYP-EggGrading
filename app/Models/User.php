<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';  // Custom table name
    protected $primaryKey = 'userID';  // Custom primary key

    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'email',
        'password',
        'roleID',
        'status',
    ];

    // Hide sensitive fields
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes to native types
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Define relationship to Role model
    public function role()
    {
        return $this->belongsTo(Role::class, 'roleID');
    }
}
