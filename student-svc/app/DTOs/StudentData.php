<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class StudentData
{
    public int $id;
    public string $studentId;
    public string $name;
    public string $email;
    public string $password;
    public int $status;
    public string $createdAt;
    public string $updatedAt;

    public static function fromRequest(Request $request) : self
    {
        $studentData = new self();
        $studentData->name = $request->get('name', "");
        $studentData->email = $request->get('email', "");
        $studentData->password = $request->get('password', "");

        return $studentData;
    }
}
