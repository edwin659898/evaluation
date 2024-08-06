<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionSix extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'extra_info',
        'employee_comments',
        'supervisor_comments',
        'manager_comments',
        'manager_date',
        'hod_comments',
    ];
}
