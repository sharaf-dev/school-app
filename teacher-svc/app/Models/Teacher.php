<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Model
{
    use HasApiTokens, HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 0;

    protected $hidden = [
        'password',
    ];
}
