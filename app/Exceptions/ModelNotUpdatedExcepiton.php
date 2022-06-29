<?php

namespace App\Exceptions;

use Exception;

class ModelNotUpdatedExcepiton extends Exception
{
    public function __construct($message = "", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
