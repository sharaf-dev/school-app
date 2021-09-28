<?php

namespace App\Repositories;

use Illuminate\Http\Client\Response;
use App\Adapters\HttpClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class StudentRepository implements IStudentRepository
{
    private string $student_svc_host;

    public function __construct(public HttpClient $httpClient)
    {
        $this->student_svc_host = env('STUDENT_SVC_HOST'); 
    }

    /**
     * Get students from student service
     * @param array $studentIds
     *
     * @return array
     */
    public function getStudents(array $studentIds) : array
    {
        $url = "$this->student_svc_host/api/students/get";
        $data = [
            "student_ids" => $studentIds
        ];
        $response = $this->httpClient->get($url, $data);

        if (!$response->successful())
        {
            return []; 
        }

        $body = $response->json();
        return Arr::get($body, 'data.students');
    }
}
