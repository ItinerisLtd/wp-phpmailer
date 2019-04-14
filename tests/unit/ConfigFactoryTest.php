<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use Codeception\Test\Unit;
use Itineris\WPPHPMailer\Drivers\MailHogDriver;
use Itineris\WPPHPMailer\Drivers\MailtrapDriver;
use Itineris\WPPHPMailer\Drivers\SendGridDriver;
use Itineris\WPPHPMailer\Exceptions\NotFoundException;
use WP_Mock;

class ConfigFactoryTest extends Unit
{
    /** @var UnitTester */
    protected $tester;

    public function testThrowDriverNotFoundException(): void
    {
        $constantRepo = new ConstantRepository();
        $driver = 'non-exist-driver';

        WP_Mock::expectFilter('wp_phpmailer_drivers', [
            'mailhog' => MailHogDriver::class,
            'sendgrid' => SendGridDriver::class,
            'mailtrap' => MailtrapDriver::class,
        ]);

        $expected = new NotFoundException("Driver 'non-exist-driver' not found, acceptable values are: Itineris\WPPHPMailer\Drivers\MailHogDriver, Itineris\WPPHPMailer\Drivers\SendGridDriver, Itineris\WPPHPMailer\Drivers\MailtrapDriver");

        $this->tester->expectThrowable($expected, function () use ($constantRepo, $driver): void {
            ConfigFactory::make($constantRepo, $driver);
        });
    }

    public function testMake(): void
    {
        $constantRepo = new ConstantRepository();
        $driver = 'mailhog';

        WP_Mock::expectFilter('wp_phpmailer_drivers', [
            'mailhog' => MailHogDriver::class,
            'sendgrid' => SendGridDriver::class,
            'mailtrap' => MailtrapDriver::class,
        ]);

        $expected = MailHogDriver::makeConfig($constantRepo);
        $actual = ConfigFactory::make($constantRepo, $driver);

        $this->assertEquals($expected, $actual);
    }
}
