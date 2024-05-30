<?php

namespace App\exceptions;

use Exception;

class InternalServerErrorException extends Exception
{
    protected $message = "Something didn't go as expected";

    protected $code = 500;

    public function __construct($message = null, $code = null, ?Exception $previous = null)
    {
        $this->message = $message ?? $this->message;
        $this->code = $code ?? $this->code;

        parent::__construct($this->message, $this->code, $previous);
    }
}
