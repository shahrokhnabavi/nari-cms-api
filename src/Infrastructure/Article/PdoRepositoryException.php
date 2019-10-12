<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Article;

use Exception;
use Throwable;

class PdoRepositoryException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable $previous
     *
     * @return PdoRepositoryException
     */
    public static function causedBy(string $message, int $code = 0, Throwable $previous = null): self
    {
        return new PdoRepositoryException($message, $code, $previous);
    }
}
