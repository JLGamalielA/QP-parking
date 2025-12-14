<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UserSubscription.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of UserSubscription model with fillables, casting and relationships according to QPK schema |
 * 
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSubscription extends Model
{
    // HasFactory<\Database\Factories\UserSubscriptionFactory>
    use HasFactory;
    // Specify the table name and primary key if they differ from Laravel's conventions
    protected $table = 'user_subscriptions';
    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'user_subscription_id';
    // Specify fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'subscription_id',
        'start_date',
        'end_date',
        'is_active',
    ];

    /**
     * Cast attributes to specific data types.
     * @return array
     */
    public function cast(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the subscription associated with the user subscription.
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the subscription associated with the user subscription.
     * @return BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'subscription_id');
    }
}
