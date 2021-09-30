<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IHomeworkService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SubmitHomeworksRequest;
use App\DTOs\HomeworkData;

class HomeworkController extends Controller
{
    public function __construct(public IHomeworkService $service) {}

    public function getHomeworks(Request $request)
    {
        $homeworks = $this->service->getHomeworks($request->user()->id);
        
        Log::info(__method__, ['status' => 'SUCCESS']);
        return response()->ok('HOMEWORKS_RETRIEVED', 'Homeworks retrieved successfully', compact('homeworks'));
    }

    public function submitHomework(SubmitHomeworksRequest $request)
    {
        try
        {
            $homeworkData = HomeworkData::fromRequest($request);
            $this->service->submitHomework($homeworkData);

            Log::info(__method__, ['status' => 'SUCCESS']);
            return response()->ok('HOMEWORK_SUBMITTED', 'Homework submitted successfully');
        }
        catch (\InvalidArgumentException $e)
        {
            Log::info(__method__, ['status' => 'FAILED']);
            return response()->badRequest('SUBMISSION_FAILED', $e->getMessage());
        }
    }
}
