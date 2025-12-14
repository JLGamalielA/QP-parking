<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SpecialParkingRole.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of SpecialParkingRole model with fillables, casting and relationships according to QPK schema |
 * 
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialParkingRole extends Model
{
    // HasFactory<\Database\Factories\SpecialParkingRoleFactory>
    use HasFactory;
    // Define the table name and primary key
    protected $table = 'special_parking_roles';
    // Define the primary key
    protected $primaryKey = 'special_parking_role_id';
    // Define fillable attributes
    protected $fillable = [
        'parking_id',
        'type',
        'special_commission_period',
        'special_commission_value',
    ];

    /**
     * The attributes that should be cast.
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'special_commission_value' => 'decimal:2',
        ];
    }

    /**
     * Get the parking that owns the special parking role.
     * @return BelongsTo
     */
    public function parking(): BelongsTo
    {
        return $this->belongsTo(Parking::class, 'parking_id', 'parking_id');
    }
}
