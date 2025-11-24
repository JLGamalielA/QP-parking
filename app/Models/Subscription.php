<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: Subscription.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Definition of Subscription model with fillables, casting and relationships according to QPK schema. |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    // HasFactory<\Database\Factories\SubscriptionFactory>
    use HasFactory;
    // Specify the table name and primary key if they differ from Laravel's conventions
    protected $table = 'subscriptions';
    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'subscription_id';
    // Specify fillable fields for mass assignment
    protected $fillable = [
        'name',
        'type',
        'cost',
    ];

    /**
     * Get the benefits for the subscription.
     * @return HasMany
     */
    public function benefits(): HasMany
    {
        return $this->hasMany(SubscriptionBenefit::class, 'subscription_id', 'subscription_id');
    }
}
