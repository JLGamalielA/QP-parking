<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UserQrScanHistory.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of UserQrScanHistory model with fillables, casting and relationships according to QPK schema. |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQrScanHistory extends Model
{
    // HasFactory<\Database\Factories\UserQrScanHistoryFactory>
    use HasFactory;
    // Define the table associated with the model
    protected $table = 'user_qr_scan_histories';
    // Define the primary key for the model
    protected $primaryKey = 'user_qr_scan_history_id';
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'parking_entry',
        'parking_exit',
        'user_id',
        'first_scan_time',
        'last_scan_time',
        'stay_duration_seconds',
        'parking_transaction_id',
    ];

    /**
     * Define the attribute casting for the model.
     * @return array
     */
    public function casts(): array
    {
        return [
            'first_scan_time' => 'datetime',
            'last_scan_time' => 'datetime',
            'stay_duration_seconds' => 'integer',
        ];
    }

    /**
     * Get the user that owns the QR scan history.
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    /**
     * Get the parking transaction associated with the QR scan history.
     * @return BelongsTo
     */
    public function parkingEntry(): BelongsTo
    {
        return $this->belongsTo(ParkingEntry::class, 'parking_entry', 'parking_entry_id');
    }

    /**
     * Get the parking exit associated with the QR scan history.
     * @return BelongsTo
     */
    public function parkingExit(): BelongsTo
    {
        return $this->belongsTo(ParkingEntry::class, 'parking_exit', 'parking_entry_id');
    }
}
