<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use PHPMailer;

class Configurator
{
    /**
     * Whitelisted PHPMailer config (property names).
     *
     * 'fromAddress', 'fromName', 'fromAuto' are special. Do not add them in mappings!
     */
    protected const MAPPINGS = [
        'SMTPAuth' => 'auth',
        'SMTPSecure' => 'protocol',
        'Host' => 'host',
        'Port' => 'port',
        'Username' => 'username',
        'Password' => 'password',
    ];

    /** @var ConfigInterface $config */
    protected $config;
    /** @var string[] $mappings */
    protected $mappings;

    public static function init(string $driver, ConstantRepository $constantRepo): Configurator
    {
        /**
         * Whitelisted PHPMailer config (property names).
         *
         * 'fromAddress', 'fromName', 'fromAuto' are special. Do not add them in mappings!
         */
        $mappings = (array) apply_filters('wp_phpmailer_config_mappings', static::MAPPINGS);
        $configFactory = ConfigFactory::make($constantRepo);
        $config = $configFactory->makeConfig($driver);

        return new static($config, $mappings);
    }

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
