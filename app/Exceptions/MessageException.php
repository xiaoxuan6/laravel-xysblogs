<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class MessageException extends Exception
{
    public function __construct(string $message = "", int $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render()
    {
        return response()->json(['msg' => $this->message, 'code' => $this->code]);
    }
}
