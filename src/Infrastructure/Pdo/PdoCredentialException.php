<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Pdo;

use Exception;
use Throwable;

class PdoCredentialException extends Exception
{
    public static function causedBy(string $message, int $code = 0, Throwable $previous = null): self
    {
        return new PdoCredentialException($message, $code, $previous);
    }
}
