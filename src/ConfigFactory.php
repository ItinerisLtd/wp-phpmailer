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

    public static function make(ConstantRepository $constantRepo): self
    {
        $drivers = (array) apply_filters('wp_phpmailer_drivers', static::DRIVERS);

        return new static($drivers, $constantRepo);
    }

    public function __construct(array $drivers, ConstantRepository $constantRepo)
    {
        $this->drivers = $drivers;
        $this->constantRepo = $constantRepo;
    }

    public function makeConfig(string $driver): ConfigInterface
    {
        $klass = $this->drivers[$driver] ?? null;
        if (null === $klass) {
            throw new RuntimeException('todo');
        }
        if (! is_subclass_of($klass, DriverInterface::class)) {
            throw new RuntimeException('todo');
        }

        /** @var DriverInterface $klass */
        return $klass::makeConfig($this->constantRepo);
    }
}
