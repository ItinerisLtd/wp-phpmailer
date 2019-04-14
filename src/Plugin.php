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
            $configurator = ConfiguratorFactory::make($constantRepo);
            $configurator->applyOn($mailer);
        }, PHP_INT_MAX - 1000);
    }
}
