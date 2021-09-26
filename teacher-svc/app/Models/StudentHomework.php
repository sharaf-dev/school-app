<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHomework extends Model
{
    use HasFactory;

    const STATUS_NEW = 0;
    CONST STATUS_SUBMITTED = 1;

    protected $fillable = [
        'homework_id',
        'student_id',
    ];
}
