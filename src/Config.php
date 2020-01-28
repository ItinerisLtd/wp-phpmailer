<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer;

class Config implements ConfigInterface
{
    /**
     * @see ConfiguratorFactory::MAPPINGS
     *
     * @var array<string, string>
     */
    protected $config = [];

    public function set(string $key, $value): ConfigInterface
    {
        $this->config[$key] = $value;

        return $this;
    }

    public function get(string $key)
    {
        return $this->config[$key] ?? null;
    }

    public function has(string $key): bool
    {
        $value = $this->get($key);

        return null !== $value;
    }

    public function unset(string $key): ConfigInterface
    {
        return $this->set($key, null);
    }
}
