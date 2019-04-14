<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

interface ConfigInterface
{
    public function has(string $key): bool;
    public function get(string $key);
    public function set(string $key, $value): self;
}
