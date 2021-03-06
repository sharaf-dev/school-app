<?php

namespace App\Exceptions;

use Exception;

class StudentNotFoundException extends NotFoundException
{
    private array $data = [];

    public function __construct(string $message = '', $data = [])
    {
        parent::__construct($message);
        $this->data = $data;
    }

    public function getData() : array
    {
        return $this->data;
    }
}
