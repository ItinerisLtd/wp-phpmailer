<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use Itineris\WPPHPMailer\Drivers\MailHogDriver;
use Itineris\WPPHPMailer\Drivers\MailtrapDriver;
use Itineris\WPPHPMailer\Drivers\SendGridDriver;
use Itineris\WPPHPMailer\Exceptions\NotFoundException;

class ConfigFactory
{
    protected const DRIVERS = [
        'mailhog' => MailHogDriver::class,
        'sendgrid' => SendGridDriver::class,
        'mailtrap' => MailtrapDriver::class,
    ];

    /** @var string[] */
    protected $drivers;
    /** @var ConstantRepository */
    protected $constantRepo;

    public static function make(ConstantRepository $constantRepo, string $driver): ConfigInterface
    {
        $drivers = (array) apply_filters('wp_phpmailer_drivers', static::DRIVERS);

        $klass = $drivers[$driver] ?? null;
        if (null === $klass) {
            $message = sprintf(
                'Driver \'%1$s\' not found, acceptable values are: %2$s',
                $driver,
                implode(
                    array_keys($drivers),
                    ', '
                )
            );

            throw new NotFoundException($message);
        }

        return $klass::makeConfig($constantRepo);
    }
}
