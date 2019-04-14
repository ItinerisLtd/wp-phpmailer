<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

class ConfiguratorFactory
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

    public static function make(ConstantRepository $constantRepo): Configurator
    {

        $driver = (string) apply_filters(
            'wp_phpmailer_driver',
            $constantRepo->getConstant('WP_PHPMAILER_DRIVER')
        );
        if ('' === $driver) {
            // TODO!
            wp_die('hello');
        }

        /**
         * Whitelisted PHPMailer config (property names).
         *
         * 'fromAddress', 'fromName', 'fromAuto' are special. Do not add them in mappings!
         */
        $mappings = (array) apply_filters('wp_phpmailer_config_mappings', static::MAPPINGS);

        $config = ConfigFactory::make($constantRepo, $driver);

        return new Configurator($config, $mappings);
    }
}
