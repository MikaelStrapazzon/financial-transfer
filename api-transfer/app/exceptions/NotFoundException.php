<?php

namespace App\exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $message = 'Resource not found.';

    protected $code = 404;

    public function __construct($message = null, $code = null, ?Exception $previous = null)
    {
        $this->message = $message ?? $this->message;
        $this->code = $code ?? $this->code;

        parent::__construct($this->message, $this->code, $previous);
    }
}
