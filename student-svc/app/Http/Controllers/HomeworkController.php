<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IHomeworkService;
use Illuminate\Support\Facades\Log;

class HomeworkController extends Controller
{
    public function __construct(public IHomeworkService $service) {}

    public function getHomeworks(Request $request)
    {
        $homeworks = $this->service->getHomeworks($request->user()->id);
        
        Log::info(__method__, ['status' => 'SUCCESS']);
        return response()->ok('HOMEWORKS_RETRIEVED', 'Homeworks retrieved successfully', compact('homeworks'));
    }
}
