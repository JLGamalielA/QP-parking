<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: User.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Adjusted for user_id PK, split names and casting |
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Relation;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Explicit definition of the primary key.
     * Critical for authentication logic because the column is 'user_id', not 'id'.
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'phone_number',
        'email',
        'password',
        'credit',
        'platform',
    ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date', // Native cast to Carbon/Date
            'credit' => 'decimal:2', // Ensures strict formatting
        ];
    }


    /**
     * Get the user's initials based on the first name attribute.
     * @return string
     */
    public function getInitialsAttribute(): string
    {
        $name = $this->first_name ?? '';
        if (empty($name)) {
            return 'NA';
        }
        $words = preg_split("/\s+/", $name, -1, PREG_SPLIT_NO_EMPTY);
        $initials = '';
        if (isset($words[0])) {
            $initials .= mb_substr($words[0], 0, 1);
        }
        if (isset($words[1])) {
            $initials .= mb_substr($words[1], 0, 1);
        }
        return strtoupper($initials);
    }

    /**
     * Accessor to maintain compatibility with the 'name' property
     * used by the Volt template in Navbar/Sidebar components.
     * Usage: $user->name
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->first_name} {$this->last_name}",
        );
    }

    /**
     * Get the general admin record associated with the user.
     * @return HasOne
     */
    public function generalAdmin(): HasOne
    {
        return $this->hasOne(GeneralAdmin::class, 'user_id', 'user_id');
    }

    /**
     * Check if the user is a general administrator.
     * @return bool
     */
    public function isGeneralAdmin(): bool
    {
        // Check if the record exists in the related table
        return $this->generalAdmin()->exists();
    }

    /**
     * Get the parking of the user.
     * Relationship: One User has One Parking.
     *
     * @return HasOne
     */
    public function parking(): HasOne
    {
        return $this->hasOne(Parking::class, 'user_id', 'user_id');
    }

    /**
     * Get the subscription associated with the user.
     * @return HasOne
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(UserSubscription::class, 'user_id', 'user_id');
    }
}
