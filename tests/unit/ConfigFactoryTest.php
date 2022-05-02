<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use Codeception\Test\Unit;
use Itineris\WPPHPMailer\SMTPDriver;
use Itineris\WPPHPMailer\Drivers\MailHogDriver;
use Itineris\WPPHPMailer\Drivers\MailtrapDriver;
use Itineris\WPPHPMailer\Drivers\Office365Driver;
use Itineris\WPPHPMailer\Drivers\SendGridDriver;
use Itineris\WPPHPMailer\Exceptions\NotFoundException;
use Mockery;
use WP_Mock;

class ConfigFactoryTest extends Unit
{
    /** @var UnitTester */
    protected $tester;

    public function testThrowDriverNotFoundException(): void
    {
        $constantRepo = Mockery::mock(
            new ConstantRepository()
        );
        $constantRepo->expects('getRequired')
            ->with('WP_PHPMAILER_DRIVER')
            ->andReturn('non-exist-driver')
            ->once();

        WP_Mock::expectFilter('wp_phpmailer_drivers', [
            'smtp' => SMTPDriver:class,
            'mailhog' => MailHogDriver::class,
            'mailtrap' => MailtrapDriver::class,
            'office365' => Office365Driver::class,
            'sendgrid' => SendGridDriver::class,
        ]);

        $expected = new NotFoundException("Driver 'non-exist-driver' not found, acceptable values are: smtp, mailhog, mailtrap, office365, sendgrid");

        $this->tester->expectThrowable($expected, function () use ($constantRepo): void {
            ConfigFactory::make($constantRepo);
        });
    }

    public function testMake(): void
    {
        $constantRepo = Mockery::mock(
            new ConstantRepository()
        );
        $constantRepo->expects('getRequired')
                     ->with('WP_PHPMAILER_DRIVER')
                     ->andReturn('mailhog')
                     ->once();

        WP_Mock::expectFilter('wp_phpmailer_drivers', [
            'smtp' => SMTPDriver:class,
            'mailhog' => MailHogDriver::class,
            'mailtrap' => MailtrapDriver::class,
            'office365' => Office365Driver::class,
            'sendgrid' => SendGridDriver::class,
        ]);

        $expected = MailHogDriver::makeConfig($constantRepo);
        $actual = ConfigFactory::make($constantRepo);

        $this->assertEquals($expected, $actual);
    }
}
