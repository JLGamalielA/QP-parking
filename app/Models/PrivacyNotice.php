<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: PrivacyNotice.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 * Modified by: Daniel Yair Mendoza Alvarez |
 * Description: Definition of PrivacyNotice model with fillables, casting and relationships according to QPK schema. |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyNotice extends Model
{
    // HasFactory<\Database\Factories\PrivacyNoticeFactory>
    use HasFactory;
    // Specify the table name and primary key if they differ from Laravel's conventions
    protected $table = 'privacy_notices';
    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'privacy_notice_id';
    // Specify fillable fields for mass assignment
    protected $fillable = ['description'];
}
