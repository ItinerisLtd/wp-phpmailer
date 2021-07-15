<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use Itineris\WPPHPMailer\Drivers\SMTPDriver;
use Itineris\WPPHPMailer\Drivers\MailHogDriver;
use Itineris\WPPHPMailer\Drivers\MailtrapDriver;
use Itineris\WPPHPMailer\Drivers\Office365Driver;
use Itineris\WPPHPMailer\Drivers\SendGridDriver;
use Itineris\WPPHPMailer\Exceptions\NotFoundException;

class ConfigFactory
{
    protected const DRIVERS = [
        'smtp' => SMTPDriver::class,
        'mailhog' => MailHogDriver::class,
        'mailtrap' => MailtrapDriver::class,
        'office365' => Office365Driver::class,
        'sendgrid' => SendGridDriver::class,
    ];

    /** @var array<string, string> */
    protected $drivers;
    /** @var ConstantRepository */
    protected $constantRepo;

    public static function make(ConstantRepository $constantRepo): ConfigInterface
    {
        $drivers = (array) apply_filters('wp_phpmailer_drivers', static::DRIVERS);
        $driver = (string) $constantRepo->getRequired('WP_PHPMAILER_DRIVER');

        $klass = $drivers[$driver] ?? null;
        if (null === $klass) {
            $message = sprintf(
                'Driver \'%1$s\' not found, acceptable values are: %2$s',
                $driver,
                implode(
                    ', ',
                    array_keys($drivers)
                )
            );

            throw new NotFoundException($message);
        }

        return $klass::makeConfig($constantRepo);
    }
}
