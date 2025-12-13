<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingEntry.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of ParkingEntry model with fillables, casting and relationships according to QPK schema. |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParkingEntry extends Model
{
    // HasFactory<\Database\Factories\ParkingEntryFactory> 
    use HasFactory;
    // Define the table associated with the model
    protected $table = 'parking_entries';
    // Define the primary key for the model
    protected $primaryKey = 'parking_entry_id';
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'parking_id',
        'name',
        'is_entry',
        'is_active',
    ];

    /**
     * Define the attribute casting for the model.
     * @return array
     */
    public function casts(): array
    {
        return [
            'is_entry' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Accessor for is_entry attribute to ensure it is returned as a boolean.
     * @return Attribute
     */
    protected function isEntry(): Attribute
    {
        return Attribute::make(
            get: fn($value) => (bool) $value,
        );
    }

    /**
     * Get the parking that owns the parking entry.
     * @return BelongsTo
     */
    public function parking(): BelongsTo
    {
        return $this->belongsTo(Parking::class, 'parking_id', 'parking_id');
    }

    /**
     * Get the active user QR scans associated with the parking entry.
     * @return HasMany
     */
    public function activeUserQrScans(): HasMany
    {
        return $this->hasMany(ActiveUserQrScan::class, 'parking_entry_id', 'parking_entry_id');
    }

    /**
     * Get the user QR scan histories associated with the parking entry.
     * @return HasMany
     */
    public function historyAsEntry()
    {
        return $this->hasMany(UserQrScanHistory::class, 'parking_entry', 'parking_entry_id');
    }

    /**
     * Get the user QR scan histories where this entry is used as exit.
     * @return HasMany
     */
    public function historyAsExit()
    {
        return $this->hasMany(UserQrScanHistory::class, 'parking_exit', 'parking_entry_id');
    }
}
