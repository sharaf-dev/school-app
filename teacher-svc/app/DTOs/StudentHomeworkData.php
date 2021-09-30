<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class StudentHomeworkData
{
    public int|null $id;
    public int|null $studentId;
    public int|null $homeworkId;
    public string|null $link;
    public string|null $submittedAt;
    public int|null $status;
    public string|null $createdAt;
    public string|null $updatedAt;

    public static function fromRequest(Request $request) : self
    {
        $homeworkData = new self();
        $homeworkData->studentId = $request->get('student_id');
        $homeworkData->homeworkId = $request->get('homework_id');
        $homeworkData->link = $request->get('link');

        return $homeworkData;
    }
}


