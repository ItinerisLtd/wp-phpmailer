<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use PHPMailer;

class Plugin
{
    public static function run(): void
    {
        // TODO: Test!
        add_action('phpmailer_init', function (PHPMailer $mailer): void {
            $constantRepo = new ConstantRepository();

            $driverConstant = $constantRepo->getConstant('WP_PHPMAILER_DRIVER');
            $driver = (string) apply_filters('wp_phpmailer_driver', $driverConstant);
            if ('' === $driver) {
                // TODO!
                wp_die('hello');
            }

            $configurator = Configurator::init($driver, $constantRepo);
            $configurator->applyOn($mailer);
        }, PHP_INT_MAX - 1000);
    }
}
