<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: SubscriptionBenefit.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of SubscriptionBenefit model with fillables, casting and relationships according to QPK schema |
 * 
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionBenefit extends Model
{
    // HasFactory<\Database\Factories\SubscriptionBenefitFactory>
    use HasFactory;
    // Specify the table name and primary key if they differ from Laravel's conventions
    protected $table = 'subscription_benefits';
    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'subscription_benefit_id';
    // Specify fillable fields for mass assignment
    protected $fillable = [
        'subscription_id',
        'benefit',
    ];

    /**
     * Get the subscription that owns the benefit.
     * @return BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'subscription_id');
    }
}
