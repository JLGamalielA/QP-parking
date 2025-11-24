<?php

/**
 * Company: CETAM
 * Project: QPK
 * File: TermCondition.php
 * Created on: 22/11/2025
 * Created by: Daniel Yair Mendoza Alvarez
 * Approved by: Daniel Yair Mendoza Alvarez
 *
 * Changelog:
 * - ID: 1 | Modified on: 22/11/2025 |
 *   Modified by: Daniel Yair Mendoza Alvarez |
 *   Description: Definition of TermCondition model with fillables, casting and relationships according to QPK schema. |
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermCondition extends Model
{
    // HasFactory<\Database\Factories\TermConditionFactory> 
    use HasFactory;
    // Specify the table name and primary key if they differ from Laravel's conventions
    protected $table = 'term_conditions';
    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'term_condition_id';
    // Specify fillable fields for mass assignment
    protected $fillable = ['description'];
}
