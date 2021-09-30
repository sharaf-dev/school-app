<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TeacherLoginRequest;
use App\DTOs\TeacherData;
use App\Services\ITeacherService;
use App\Exceptions\TeacherNotFoundException;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    public function __construct(public ITeacherService $service) {}

    public function login(TeacherLoginRequest $request)
    {
        try
        {
            $teacherData = TeacherData::fromRequest($request);
            $teacher = $this->service->authenticate($teacherData);

            $data = [
                'token' => $this->service->createToken($teacher)
            ];

            Log::info(__method__, ['status' => 'SUCCESS', 'teacher_id' => $teacher->teacher_id]);
            return response()->ok('LOGIN_SUCCESS', 'Teacher login successful', $data);
        }
        catch (TeacherNotFoundException $ex)
        {
            Log::info(__method__, ['status' => 'FAILED', 'ip_address' => $request->ip()]);
            return response()->unauthorized('LOGIN_FAILED', 'Email or password incorrect.');
        }
    } 
}
