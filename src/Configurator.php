<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use PHPMailer;

class Configurator
{
    /** @var ConfigInterface $config */
    protected $config;
    /** @var array<string, string> $mappings */
    protected $mappings;

    /**
     * Configurator constructor.
     *
     * @param ConfigInterface       $config   The config instance.
     * @param array<string, string> $mappings The mappings.
     */
    public function __construct(ConfigInterface $config, array $mappings)
    {
        $this->config = $config;
        $this->mappings = $mappings;
    }

    public function applyOn(PHPMailer $mailer): void
    {
        $mailer->isSMTP();

        foreach ($this->mappings as $property => $key) {
            if (! $this->config->has($key)) {
                continue;
            }

            $mailer->$property = $this->config->get($key);
        }

        if ($this->config->has('fromAddress')) {
            $mailer->setFrom(
                $this->config->get('fromAddress'),
                $this->config->get('fromName') ?? '',
                $this->config->get('fromAuto') ?? true
            );
        }
    }
}
