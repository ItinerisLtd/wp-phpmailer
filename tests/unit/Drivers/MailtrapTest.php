<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer\Drivers;

use Codeception\Test\Unit;
use Itineris\WPPHPMailer\Config;
use Itineris\WPPHPMailer\ConstantRepository;
use Mockery;

class MailtrapTest extends Unit
{
    public function testMakeConfig()
    {
        $username = 'my-mailtrap-username';
        $password = 'my-mailtrap-password';

        $configRepo = Mockery::mock(ConstantRepository::class);

        $configRepo->expects()->getRequiredConstant('MAILTRAP_USERNAME')->andReturns($username);
        $configRepo->expects()->getRequiredConstant('MAILTRAP_PASSWORD')->andReturns($password);

        $subject = Mailtrap::makeConfig($configRepo);

        $this->assertInstanceOf(Config::class, $subject);

        $this->assertTrue($subject->get('auth'));
        $this->assertSame('smtp.mailtrap.io', $subject->get('host'));
        $this->assertSame(2525, $subject->get('port'));
        $this->assertSame('tls', $subject->get('protocol'));

        $this->assertSame($username, $subject->get('username'));
        $this->assertSame($password, $subject->get('password'));
    }
}
