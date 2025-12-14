<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: ParkingTransaction.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of ParkingTransaction model with fillables, casting and relationships according to QPK schema |
 * 
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParkingTransaction extends Model
{
    // HasFactory<\Database\Factories\ParkingTransactionFactory>
    use HasFactory;
    // Define the table associated with the model
    protected $table = 'parking_transactions';
    // Define the primary key for the model
    protected $primaryKey = 'parking_transaction_id';
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'parking_id',
        'user_id',
        'amount_paid',
    ];

    /**
     * Define the attribute casting for the model.
     * @return array
     */
    public function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
        ];
    }
    
    /**
     * Get the parking that owns the parking transaction.
     * @return BelongsTo
     */
    public function parking(): BelongsTo
    {
        return $this->belongsTo(Parking::class, 'parking_id', 'parking_id');
    }

    /**
     * Get the user that owns the parking transaction.
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }   

    
}
