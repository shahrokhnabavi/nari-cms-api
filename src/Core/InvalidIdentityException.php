<?php
declare(strict_types = 1);

namespace SiteApi\Core;

use InvalidArgumentException;

/**
 * @codeCoverageIgnore
 */
class InvalidIdentityException extends InvalidArgumentException
{
    /**
     * @param string $message
     *
     * @return InvalidIdentityException
     */
    public static function throw(string $message): self
    {
        throw new static($message);
    }
}
