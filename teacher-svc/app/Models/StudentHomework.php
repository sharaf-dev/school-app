<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHomework extends Model
{
    use HasFactory;

    protected $table = 'student_homework';

    const STATUS_NEW = 0;
    CONST STATUS_SUBMITTED = 1;

    protected $fillable = [
        'homework_id',
        'student_id',
    ];

    public function homework()
    {
        return $this->belongsTo(Homework::class);
    }

    public function isSubmitted() : bool
    {
        return $this->status == self::STATUS_SUBMITTED;
    }
}
