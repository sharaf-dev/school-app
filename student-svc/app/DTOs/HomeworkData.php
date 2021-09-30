<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class HomeworkData
{
    public int|null $id;
    public int|null $studentId;
    public int|null $homeworkId;
    public string|null $link;
    public string|null $createdAt;
    public string|null $updatedAt;

    public static function fromRequest(Request $request) : self
    {
        $homeworkData = new self();
        $homeworkData->studentId = $request->user()->id;
        $homeworkData->homeworkId = $request->get('homework_id');
        $homeworkData->link = $request->get('link');

        return $homeworkData;
    }

    public function toRequestPayload() : array
    {
        $data = [
            'student_id' => $this->studentId,
            'homework_id' => $this->homeworkId,
            'link' => $this->link
        ];

        return $data;
    }
}
