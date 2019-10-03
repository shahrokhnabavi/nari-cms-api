<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Configuration;

interface ConfigurationInterface
{
    /**
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;
}
