<?php
declare(strict_types = 1);

namespace SiteApi\Domain\Article;

use Exception;
use Throwable;

class ArticleAlreadyExistsException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     *
     * @return ArticleAlreadyExistsException
     */
    public static function causedBy(string $message, int $code = 0, Throwable $previous = null): self
    {
        return new ArticleAlreadyExistsException($message, $code, $previous);
    }
}
