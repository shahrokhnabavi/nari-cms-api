<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Pdo;

use Exception;
use Throwable;

class PdoCredentialException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     *
     * @return PdoCredentialException
     */
    public static function causedBy(string $message, int $code = 0, Throwable $previous = null): self
    {
        return new PdoCredentialException($message, $code, $previous);
    }
}
