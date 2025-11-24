<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ActiveUserQrScan.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of ActiveUserQrScan model with fillables, casting and relationships according to QPK schema. |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActiveUserQrScan extends Model
{
    // HasFactory<\Database\Factories\ActiveUserQrScanFactory> 
    use HasFactory;
    // Define the table associated with the model
    protected $table = 'active_user_qr_scans';
    // Define the primary key for the model
    protected $primaryKey = 'active_user_qr_scan_id';
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'parking_entry_id',
        'user_id',
        'scan_time',
    ];

    // Define the attribute casting for the model
    protected $casts = [
        'scan_time' => 'datetime',
    ];

    /**
     * Get the parking entry associated with the active user QR scan.
     * @return BelongsTo
     */
    public function parkingEntry(): BelongsTo
    {
        return $this->belongsTo(ParkingEntry::class, 'parking_entry_id', 'parking_entry_id');
    }

    /**
     * Get the user associated with the active user QR scan.
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
