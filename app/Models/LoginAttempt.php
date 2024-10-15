<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;



class LoginAttempt extends Model
{
    
    protected $fillable = ['email', 'attempts', 'total_attempts', 'block_attempts', 'blocked_until'];

    /**
     * Check if the user is currently blocked.
     *
     * @return bool
     */
    public function isBlocked()
    {
        return $this->blocked_until && Carbon::now()->lessThan($this->blocked_until);
    }

    /**
     * Increment both total attempts and block attempts.
     *
     * @return void
     */
    public function incrementAttempts()
    {
        $this->attempts++;
        $this->total_attempts++;
        // Check if total_attempts is a multiple of 3
        if ($this->attempts % 3 === 0) {
            $this->block_attempts++; // Increase block_attempts every 3rd attempt
        }
    
        $this->save();
    }

    /**
     * Block the user for a specified number of minutes and reset the block_attempts counter.
     *
     * @param int $minutes
     * @return void
     */
    public function block($minutes)
    {
        $this->blocked_until = Carbon::now()->addMinutes($minutes);
        $this->attempts = 0;
        $this->save();
    }

    /**
     * Define cast types for specific attributes.
     *
     * @var array
     */
    protected $casts = [
        'blocked_until' => 'datetime',
    ];
}
