<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use Itineris\WPPHPMailer\Drivers\DriverInterface;
use Itineris\WPPHPMailer\Drivers\MailHog;
use Itineris\WPPHPMailer\Drivers\Mailtrap;
use Itineris\WPPHPMailer\Drivers\SendGrid;
use RuntimeException;

class ConfigFactory
{
    protected const DRIVERS = [
        'mailhog' => MailHog::class,
        'sendgrid' => SendGrid::class,
        'mailtrap' => Mailtrap::class,
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
            throw new RuntimeException('todo');
        }
        if (! is_subclass_of($klass, DriverInterface::class)) {
            throw new RuntimeException('todo');
        }

        return $klass::makeConfig($constantRepo);
    }
}
