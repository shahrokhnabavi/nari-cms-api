<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Configuration;

use Noodlehaus\Config;

class ConfigurationAdapter implements ConfigurationInterface
{
    /** @var Config */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->config->get($key, $default);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->config->has($key);
    }
}
