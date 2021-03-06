<?php

declare(strict_types=1);

namespace App\Exceptions\Repository;

use Exception;
use Throwable;

class NotFoundException extends Exception
{
    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
