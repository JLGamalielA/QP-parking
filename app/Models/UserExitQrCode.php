<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: UserExitQrCode.php
 * Created on: 09/12/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 09/12/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: UserExitQrCode model implementation for manual exit QR codes. |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserExitQrCode extends Model
{
    use HasFactory;

    protected $table = 'user_exit_qr_codes';
    protected $primaryKey = 'user_exit_qr_code_id';

    protected $fillable = [
        'user_id',
        'parking_id',
        'value',
    ];

    /**
     * Define the relationship to the User model.
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
