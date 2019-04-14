<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

interface ConfigInterface
{
    public function has(string $key): bool;

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function get(string $key);

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return ConfigInterface
     */
    public function set(string $key, $value): self;
}
