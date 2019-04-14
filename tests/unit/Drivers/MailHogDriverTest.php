<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer\Drivers;

use Codeception\Test\Unit;
use Itineris\WPPHPMailer\Config;
use Itineris\WPPHPMailer\ConstantRepository;
use Mockery;

class MailHogDriverTest extends Unit
{
    public function testMakeConfig()
    {
        $configRepo = Mockery::mock(ConstantRepository::class);

        $subject = MailHogDriver::makeConfig($configRepo);

        $this->assertInstanceOf(Config::class, $subject);

        $this->assertSame('127.0.0.1', $subject->get('host'));
        $this->assertSame(1025, $subject->get('port'));
    }
}
