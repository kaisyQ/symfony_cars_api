<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends \Exception
{
    public function __construct(
        string $message = "Resource is not found", int $code = Response::HTTP_NOT_FOUND, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}