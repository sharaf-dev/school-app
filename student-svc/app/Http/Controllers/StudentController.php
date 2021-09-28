<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StudentLoginRequest;
use App\Http\Requests\GetStudentsRequest;
use App\DTOs\StudentData;
use App\Services\IStudentService;
use App\Exceptions\StudentNotFoundException;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function __construct(public IStudentService $service) {}

    public function login(StudentLoginRequest $request)
    {
        try {
            $studentData = StudentData::fromRequest($request);
            $student = $this->service->authenticate($studentData);

            $data = [
                'token' => $this->service->createToken($student)
            ];

            Log::info(__method__, ['status' => 'SUCCESS', 'student_id' => $student->student_id]);
            return response()->ok('LOGIN_SUCCESS', 'Student login successful', $data);

        } catch (StudentNotFoundException $ex) {
            Log::info(__method__, ['status' => 'FAILED', 'ip_address' => $request->ip()]);
            return response()->unauthorized('LOGIN_FAILED', 'Email or password incorrect.');
        }
    }

    public function getStudents(GetStudentsRequest $request)
    {
        $studentIds = $request->get("student_ids");
        $students = $this->service->getStudents($studentIds);

        Log::info(__method__, ['status' => 'SUCCESS']);
        return response()->ok('STUDENTS_RETRIEVED', 'Students retrieved successful', compact('students'));
    }
}
