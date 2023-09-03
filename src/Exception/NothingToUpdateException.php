<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class NothingToUpdateException extends \Exception
{
    public function __construct(
        string $message = "There is nothing to update!", int $code = Response::HTTP_NO_CONTENT, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}