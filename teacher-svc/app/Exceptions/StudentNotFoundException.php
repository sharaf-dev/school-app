<?php

namespace App\Exceptions;

use Exception;

class StudentNotFoundException extends NotFoundException
{
    public function __construct(public array $studentIds) {}
}
