<?php

namespace App\DTOs;

use Illuminate\Http\Request;
use App\Models\Homework;

class HomeworkData
{
    public int|null $id;
    public string|null $title;
    public string|null $description;
    public array|null $assignees;
    public int|null $teacherId;
    public string|null $createdAt;
    public string|null $updatedAt;

    public static function fromRequest(Request $request) : self
    {
        $homeworkData = new self();
        $homeworkData->title = $request->get('title');
        $homeworkData->description = $request->get('description');
        $homeworkData->assignees = $request->get('assignees');
        $homeworkData->teacherId = $request->user()->id;

        return $homeworkData;
    }

    public static function fromModel(Homework $homework) : self
    {
        $homeworkData = new self();
        $homeworkData->id = $homework->id;
        $homeworkData->title = $homework->title;
        $homeworkData->description = $homework->description;
        $homeworkData->assignees = $homework->assignees;
        $homeworkData->teacherId = $homework->teacher_id;
        $homeworkData->createdAt = $homework->created_at;
        $homeworkData->updatedAt = $homework->updated_at;

        return $homeworkData;
    }
}

