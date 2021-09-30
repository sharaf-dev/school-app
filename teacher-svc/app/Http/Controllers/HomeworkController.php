<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateHomeworkRequest;
use App\Http\Requests\AssignHomeworkRequest;
use App\Http\Requests\GetHomeworksRequest;
use App\Http\Requests\SubmitHomeworksRequest;
use App\Services\IHomeworkService;
use App\Services\IStudentService;
use App\DTOs\HomeworkData;
use App\DTOs\StudentHomeworkData;
use Illuminate\Support\Facades\Log;
use App\Exceptions\HomeworkNotFoundException;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\ArgumentException;

class HomeworkController extends Controller
{
    public function __construct(
        public IHomeworkService $service,
        public IStudentService $studentService,
    ) {}

    public function createHomework(CreateHomeworkRequest $request)
    {
        try
        {
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

        }
        catch (StudentNotFoundException $e)
        {
            Log::info(__method__, ['status' => 'FAILED']);
            return response()->notFound('STUDENTS_NOT_FOUND', $e->getMessage(), $e->getData());
        }
        catch (ArgumentException $e)
        {
            Log::info(__method__, ['status' => 'ASSIGNMENT_FAILED']);
            return response()->badRequest('ASSIGNMENT_FAILED', $e->getMessage(), $e->getData());
        }
    }

    public function assignHomework(AssignHomeworkRequest $request)
    {
        try
        {
            $homeworkData = HomeworkData::fromRequest($request);
            $this->studentService->validateStudents($homeworkData->assignees);
            $homework = $this->service->getHomework($homeworkData->id);
            $this->service->assignHomework($homeworkData);

            $data = [
                'homework_id' => $homework->id,
                'students' => $homeworkData->assignees
            ];

            Log::info(__method__, ['status' => 'ASSIGNED']);
            return response()->ok('HOMEWORK_ASSIGNED', 'Homework assigned to students', $data);

        }
        catch (HomeworkNotFoundException $e)
        {
            Log::info(__method__, ['status' => 'FAILED']);
            return response()->notFound('HOMEWORK_NOT_FOUND', 'Homework not found');
        }
        catch (StudentNotFoundException $e)
        {
            Log::info(__method__, ['status' => 'FAILED']);
            return response()->notFound('STUDENTS_NOT_FOUND', $e->getMessage(), $e->getData());
        }
        catch (ArgumentException $e)
        {
            Log::info(__method__, ['status' => 'ASSIGNMENT_FAILED']);
            return response()->badRequest('ASSIGNMENT_FAILED', $e->getMessage(), $e->getData());
        }
    }

    public function getHomeworks(GetHomeworksRequest $request)
    {
        $studentId = $request->get('student_id');
        $homeworks = $this->service->getHomeworks($studentId);

        Log::info(__method__, ['status' => 'SUCCESS']);
        return response()->ok('HOMEWORKS_RETRIEVED', 'Homeworks retrieved successfully', compact('homeworks'));
    }

    public function submitHomework(SubmitHomeworksRequest $request)
    {
        try
        {
            $homeworkData = StudentHomeworkData::fromRequest($request);
            $this->service->submitHomework($homeworkData);

            Log::info(__method__, ['status' => 'SUCCESS']);
            return response()->ok('HOMEWORK_SUBMITTED', 'Homework submitted successfully');
        }
        catch (HomeworkNotFoundException $e)
        {
            Log::info(__method__, ['status' => 'FAILED']);
            return response()->notFound('HOMEWORK_NOT_FOUND', 'Homework not found');
        }
        catch (ArgumentException $e)
        {
            Log::info(__method__, ['status' => 'FAILED']);
            return response()->badRequest('SUBMISSION_FAILED', $e->getMessage());
        }
    }
}
