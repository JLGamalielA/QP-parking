<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SpecialUserParkingRequest.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Definition of SpecialUserParkingRequest model with fillables, casting and relationships according to QPK schema. |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialUserParkingRequest extends Model
{
    // HasFactory<\Database\Factories\SpecialUserParkingRequestFactory>
    use HasFactory;
    // Define the table associated with the model
    protected $table = 'special_user_parking_requests';
    // Define the primary key for the model
    protected $primaryKey = 'special_user_parking_request_id'; 
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'parking_id',
        'user_id',
        'special_parking_role_id',
    ];
    
    /**
     * Get the user that owns the special user parking request.
     * @return BelongsTo
     */
    public function parking(): BelongsTo
    {
        return $this->belongsTo(Parking::class, 'parking_id', 'parking_id');
    }

    /**
     * Get the user that owns the special user parking request.
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the special parking role associated with the special user parking request.
     * @return BelongsTo
     */
    public function specialParkingRole(): BelongsTo
    {
        return $this->belongsTo(SpecialParkingRole::class, 'special_parking_role_id', 'special_parking_role_id');
    }
}
