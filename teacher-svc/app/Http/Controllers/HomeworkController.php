<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateHomeworkRequest;
use App\Http\Requests\AssignHomeworkRequest;
use App\Services\IHomeworkService;
use App\Services\IStudentService;
use App\DTOs\HomeworkData;
use Illuminate\Support\Facades\Log;
use App\Exceptions\HomeworkNotFoundException;
use App\Exceptions\StudentNotFoundException;

class HomeworkController extends Controller
{
    public function __construct(
        public IHomeworkService $service,
        public IStudentService $studentService,
    ) {}

    public function createHomework(CreateHomeworkRequest $request)
    {
        try {
            $homeworkData = HomeworkData::fromRequest($request);
            $this->studentService->validateStudents($homeworkData->assignees);

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

            Log::info(__method__, ['status' => 'ASSIGNED']);
            return response()->ok('HOMEWORK_CREATED_ASSIGNED', 'Homework created and assigned', $data);

        } catch (StudentNotFoundExecption $ex){
            Log::info(__method__, ['status' => 'FAILED']);
            return response()->notFound('STUDENTS_NOT_FOUND', 'Students not found', ['students' => $ex->studentIds]);
        }
    }

    public function assignHomework(AssignHomeworkRequest $request)
    {
        try {
            $homeworkData = HomeworkData::fromRequest($request);
            $this->studentService->validateStudents($homeworkData->assignees);

            $homeworkId = $request->get("homework_id");
            $homework = $this->service->getHomework($homeworkId);
            $this->service->assignHomework($homeworkData);

            $data = [
                'homework_id' => $homeworkData->id,
                'students' => $homeworkData->assignees
            ];

            Log::info(__method__, ['status' => 'ASSIGNED']);
            return response()->ok('HOMEWORK_ASSIGNED', 'Homework assigned to students', $data);

        } catch (HomeworkNotFoundException $ex) {
            Log::info(__method__, ['status' => 'FAILED']);
            return response()->notFound('HOMEWORK_NOT_FOUND', 'Homework not found');
        } catch (StudentNotFoundException $ex){
            Log::info(__method__, ['status' => 'FAILED']);
            return response()->notFound('STUDENTS_NOT_FOUND', 'Students not found', ['students' => $ex->studentIds]);
        }
    }
}
