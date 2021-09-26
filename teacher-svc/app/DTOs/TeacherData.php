<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class TeacherData
{
    public int $id;
    public string $teacherId;
    public string $name;
    public string $email;
    public string $password;
    public int $status;
    public string $createdAt;
    public string $updatedAt;

    public static function fromRequest(Request $request) : self
    {
        $teacherData = new self();
        $teacherData->name = $request->get('name', "");
        $teacherData->email = $request->get('email', "");
        $teacherData->password = $request->get('password', "");

        return $teacherData;
    }
}
