<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

class ConfiguratorFactory
{
    /**
     * Whitelisted PHPMailer configuration (property names).
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

    public static function make(ConstantRepository $constantRepo): Configurator
    {
        // TODO: Refactor!
        $config = ConfigFactory::make(
            $constantRepo,
            (string) $constantRepo->get('WP_PHPMAILER_DRIVER')
        );

        /**
         * Whitelisted PHPMailer configuration (property names).
         *
         * 'fromAddress', 'fromName', 'fromAuto' are special. Do not add them in mappings!
         */
        $mappings = (array) apply_filters('wp_phpmailer_config_mappings', static::MAPPINGS);

        return new Configurator($config, $mappings);
    }
}
