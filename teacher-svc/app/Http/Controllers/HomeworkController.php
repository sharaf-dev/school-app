<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateHomeworkRequest;
use App\Services\IHomeworkService;
use App\DTOs\HomeworkData;
use Illuminate\Support\Facades\Log;

class HomeworkController extends Controller
{
    public function __construct(public IHomeworkService $service) {}

    public function createHomework(CreateHomeworkRequest $request)
    {
        $homeworkData = HomeworkData::fromRequest($request);
        $homework = $this->service->createHomework($homeworkData);

        Log::info(__method__, ['status' => 'CREATED', 'homework_id' => $homework->id]);

        $data = [
            'homework_id' => $homework->id
        ];

        if (empty($homeworkData->assignees))
        {
            return response()->ok('HOMEWORK_CREATED', 'Homework created successful', $data);
        }

        $homeworkData->id = $homework->id;
        $this->service->assignHomework($homeworkData);
        $data['students'] = $homeworkData->assignees;

        Log::info(__method__, ['status' => 'ASSIGNED', 'assignees' => $homeworkData->assignees]);
        return response()->ok('HOMEWORK_CREATED_ASSIGNED', 'Homework created and assigned', $data);
    }
}
