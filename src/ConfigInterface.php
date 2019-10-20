<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer;

interface ConfigInterface
{
    public function has(string $key): bool;

    /**
     * @param string $key Key of the config.
     *
     * @return mixed|null
     */
    public function get(string $key);

    /**
     * @param string $key   Key of the config.
     * @param mixed  $value Value of the config.
     *
     * @return ConfigInterface
     */
    public function set(string $key, $value): self;
}
