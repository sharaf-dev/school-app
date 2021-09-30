<?php

namespace App\Exceptions;

use Exception;

class ArgumentException extends Exception
{
    private $data = [];

    public function __construct($message = '', $data = [])
    {
        parent::__construct($message);
        $this->data = $data;
    }

    public function getData() : array
    {
        return $this->data;
    }
}
