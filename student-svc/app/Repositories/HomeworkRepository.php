<?php

namespace App\Repositories;

use App\Adapters\IHttpClient;
use Illuminate\Support\Arr;

class HomeworkRepository implements IHomeworkRepository
{
    private string $teacherSvcHost = "";

    public function __construct(public IHttpClient $httpClient)
    {
        $this->teacherSvcHost = env("TEACHER_SVC_HOST"); 
    }

    /**
     * Get homeworks
     * @param int $studentId
     *
     * @return array
     */
    public function getHomeworks(int $studentId) : array
    {
        $url = "{$this->teacherSvcHost}/api/homework/get";
        $data = [ 'student_id' => $studentId ];
        $response = $this->httpClient->get($url, $data);

        if (!$response->successful())
        {
            return []; 
        }

        $body = $response->json();
        return Arr::get($body, 'data.homeworks');
    }
}
