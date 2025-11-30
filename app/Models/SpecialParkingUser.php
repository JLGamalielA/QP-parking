<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SpecialParkingUser.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of SpecialParkingUser model with fillables, casting and relationships according to QPK schema. |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialParkingUser extends Model
{
    // HasFactory<\Database\Factories\SpecialParkingUserFactory> 
    use HasFactory;
    // Define the table associated with the model
    protected $table = 'special_parking_users';
    // Define the primary key for the model
    protected $primaryKey = 'special_parking_user_id';
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'parking_id',
        'special_parking_role_id',
        'permission_start_date',
    ];
    // Define the attribute casting
    protected $casts = [
        'permission_start_date' => 'datetime',
    ];

    /**
     * Get the user that owns the special parking user.
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the parking that owns the special parking user.
     * @return BelongsTo
     */
    public function parking(): BelongsTo
    {
        return $this->belongsTo(Parking::class, 'parking_id', 'parking_id');
    }

    /**
     * Get the special parking role that owns the special parking user.
     * @return BelongsTo
     */
    public function specialParkingRole(): BelongsTo
    {
        return $this->belongsTo(SpecialParkingRole::class, 'special_parking_role_id', 'special_parking_role_id');
    }
}
