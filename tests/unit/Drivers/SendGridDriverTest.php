<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer\Drivers;

use Codeception\Test\Unit;
use Itineris\WPPHPMailer\Config;
use Itineris\WPPHPMailer\ConstantRepository;
use Mockery;

class SendGridDriverTest extends Unit
{
    public function testMakeConfig()
    {
        $apiKey = 'my-sendgrid-api-key';

        $configRepo = Mockery::mock(ConstantRepository::class);

        $configRepo->expects()->getRequired('SENDGRID_API_KEY')->andReturns($apiKey);
        $configRepo->allows()->get(Mockery::any())->andReturns(null);

        $subject = SendGridDriver::makeConfig($configRepo);

        $this->assertInstanceOf(Config::class, $subject);

        $this->assertTrue($subject->get('auth'));
        $this->assertSame('smtp.sendgrid.net', $subject->get('host'));
        $this->assertSame(587, $subject->get('port'));
        $this->assertSame('tls', $subject->get('protocol'));
        $this->assertSame('apikey', $subject->get('username'));

        $this->assertSame($apiKey, $subject->get('password'));

        $this->assertFalse($subject->has('fromAddress'));
    }

    public function testMakeConfigWithFrom()
    {
        $apiKey = 'my-sendgrid-api-key';
        $fromAddress = 'my@from.address';
        $fromName = 'My From Name';
        $fromAuto = true;

        $configRepo = Mockery::mock(ConstantRepository::class);

        $configRepo->expects()->getRequired('SENDGRID_API_KEY')->andReturns($apiKey);
        $configRepo->expects()->get('SENDGRID_FROM_ADDRESS')->andReturns($fromAddress);
        $configRepo->expects()->get('SENDGRID_FROM_NAME')->andReturns($fromName);
        $configRepo->expects()->get('SENDGRID_FROM_AUTO')->andReturns($fromAuto);

        $subject = SendGridDriver::makeConfig($configRepo);

        $this->assertInstanceOf(Config::class, $subject);

        $this->assertTrue($subject->get('auth'));
        $this->assertSame('smtp.sendgrid.net', $subject->get('host'));
        $this->assertSame(587, $subject->get('port'));
        $this->assertSame('tls', $subject->get('protocol'));
        $this->assertSame('apikey', $subject->get('username'));

        $this->assertSame($apiKey, $subject->get('password'));

        $this->assertTrue($subject->has('fromAddress'));
        $this->assertSame($fromAddress, $subject->get('fromAddress'));
        $this->assertSame($fromName, $subject->get('fromName'));
        $this->assertSame($fromAuto, $subject->get('fromAuto'));
    }
}
