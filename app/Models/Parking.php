<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: Parking.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of Parking model with fillables, casting and relationships according to QPK schema. |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

class Parking extends Model
{
    // HasFactory<\Database\Factories\ParkingFactory>
    use HasFactory;
    /**
     * The primary key associated with the table.
     * Required because the migration uses 'parking_id' instead of 'id'.
     *
     * @var string
     */
    protected $primaryKey = 'parking_id';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parkings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'price_per_hour',
        'fixed_price',
        'latitude',
        'longitude',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price_per_hour' => 'decimal:2',
            'fixed_price' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            // Note: opening_time and closing_time are auto-cast to string 'H:i:s' by Laravel default behavior for time columns
        ];
    }

    /**
     * Get the human-readable label for the commission period.
     * Eloquent Accessor to format 3600 as 'por hora' and 86400 as 'por día'.
     *
     * @return string
     */
    // public function getPeriodLabelAttribute(): string
    // {
    //     return match ($this->commission_period) {
    //         3600 => 'por hora',
    //         86400 => 'por día',
    //         default => $this->commission_period . ' seg',
    //     };
    // }

    /**
     * Get the user that owns the parking.
     * Relationship: Parking belongs to one User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the schedules for the parking.
     * Relationship: One Parking has Many Schedules (one per weekday).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(): HasMany
    {
        // Arguments: Related Model, Foreign Key, Local Key
        return $this->hasMany(ParkingSchedule::class, 'parking_id', 'parking_id');
    }

    /**
     * Get the special parking roles associated with the parking.
     * Relationship: One Parking has Many SpecialParkingRoles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specialParkingRoles(): HasMany
    {
        return $this->hasMany(SpecialParkingRole::class, 'parking_id', 'parking_id');
    }

    /**
     * Get the parking entries (readers) associated with the parking.
     * Relationship: One Parking has Many ParkingEntries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parkingEntries(): HasMany
    {
        return $this->hasMany(ParkingEntry::class, 'parking_id', 'parking_id');
    }
}
