<?php
declare(strict_types = 1);

namespace SiteApi\Application\CommandBus;

interface CommandBusInterface
{
    /**
     * @param $command
     *
     * @return void
     */
    public function handler(Command $command): void;
}
