<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingSchedule.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Definition of ParkingSchedule model handling operating hours per weekday. |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class ParkingSchedule extends Model
{
    /** @use HasFactory<\Database\Factories\ParkingScheduleFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parking_schedules';

    /**
     * The primary key associated with the table.
     * Required because the migration uses 'parking_schedule_id' instead of 'id'.
     *
     * @var string
     */
    protected $primaryKey = 'parking_schedule_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parking_id',
        'weekday',
        'is_open',
        'opening_time',
        'closing_time',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'weekday' => 'integer',
            'is_open' => 'boolean',
            // Time columns are automatically cast to 'H:i:s' strings by default in Laravel
        ];
    }

    /**
     * Get the parking lot that owns this schedule.
     * Relationship: ParkingSchedule belongs to one Parking.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parking(): Relation
    {
        // Arguments: Related Model, Foreign Key, Owner Key
        return $this->belongsTo(Parking::class, 'parking_id', 'parking_id');
    }
}
