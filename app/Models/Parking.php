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
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Definition of Parking model with fillables, casting and relationships according to QPK schema. |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

class Parking extends Model
{
    /** @use HasFactory<\Database\Factories\ParkingFactory> */
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
        'address',
        'commission_period',
        'commission_value',
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
            'commission_value' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            // Note: opening_time and closing_time are auto-cast to string 'H:i:s' by Laravel default behavior for time columns
        ];
    }

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
}
