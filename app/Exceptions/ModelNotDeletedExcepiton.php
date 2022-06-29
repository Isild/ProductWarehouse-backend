<?php

namespace App\Exceptions;

use Exception;

class ModelNotDeletedExcepiton extends Exception
{
    public function __construct($message = "", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
