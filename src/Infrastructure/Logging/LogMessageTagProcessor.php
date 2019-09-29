<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Logging;

class LogMessageTagProcessor
{
    /** @var string[] */
    private static $tags = [];

    /**
     * @param string[] $record
     *
     * @return string[]
     */
    public function __invoke(array $record): array
    {
        $record['extra'] = array_merge(($record['extra'] ?? []), self::$tags);

        return $record;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public static function addTag(string $key, string $value): void
    {
        self::$tags[$key] = $value;
    }
}
