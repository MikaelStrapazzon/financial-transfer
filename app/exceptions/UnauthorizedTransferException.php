<?php

namespace App\exceptions;

use Exception;

class UnauthorizedTransferException extends Exception
{
    protected $message = 'Unauthorized transfer.';

    protected $code = 403;

    public function __construct($message = null, $code = null, ?Exception $previous = null)
    {
        $this->message = $message ?? $this->message;
        $this->code = $code ?? $this->code;

        parent::__construct($this->message, $this->code, $previous);
    }
}
