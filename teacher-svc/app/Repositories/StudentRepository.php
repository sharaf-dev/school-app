<?php

namespace App\Repositories;

use Illuminate\Http\Client\Response;
use App\Adapters\IHttpClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class StudentRepository implements IStudentRepository
{
    private string $studentSvcHost;

    public function __construct(public IHttpClient $httpClient)
    {
        $this->studentSvcHost = env('STUDENT_SVC_HOST');
    }

    /**
     * Get students from student service
     * @param array $studentIds
     *
     * @return array
     */
    public function getStudents(array $studentIds) : array
    {
        $url = "{$this->studentSvcHost}/api/students/get";
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
