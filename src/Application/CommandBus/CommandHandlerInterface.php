<?php
declare(strict_types = 1);

namespace SiteApi\Application\CommandBus;

interface CommandHandlerInterface
{
    /**
     * @return string[]
     */
    public static function handlesCommand(): array;
}
