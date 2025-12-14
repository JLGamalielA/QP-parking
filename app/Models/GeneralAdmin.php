<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: GeneralAdmin.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of GeneralAdmin model with fillables, casting and relationships according to QPK schema |
 * 
 */


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeneralAdmin extends Model
{
    // HasFactory<\Database\Factories\GeneralAdminFactory>
    use HasFactory;
    // Specify the table name if it's not the plural of the model name.
    protected $table = 'general_admins';
    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'general_admin_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user that owns the general admin.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
