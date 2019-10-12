<?php
declare(strict_types = 1);

namespace SiteApi\Domain\Article;

use Exception;
use Throwable;

class ArticleNotFoundException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     *
     * @return ArticleNotFoundException
     */
    public static function causedBy(string $message, int $code = 0, Throwable $previous = null): self
    {
        return new ArticleNotFoundException($message, $code, $previous);
    }
}
