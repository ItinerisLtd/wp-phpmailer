<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer\Drivers;

use Itineris\WPPHPMailer\Config;
use Itineris\WPPHPMailer\ConfigInterface;
use Itineris\WPPHPMailer\ConstantRepository;

class SendGrid implements DriverInterface
{
    public static function makeConfig(ConstantRepository $constantRepo): ConfigInterface
    {
        $config = new Config();

        $config->set('auth', true);
        $config->set('host', 'smtp.sendgrid.net');
        $config->set('port', 587);
        $config->set('protocol', 'tls');
        $config->set('username', 'apikey');

        $config->set(
            'password',
            $constantRepo->getRequiredConstant('SENDGRID_API_KEY')
        );

        $config->set(
            'fromAddress',
            $constantRepo->getConstant('SENDGRID_FROM_ADDRESS')
        );
        $config->set(
            'fromName',
            $constantRepo->getConstant('SENDGRID_FROM_NAME')
        );
        $config->set(
            'fromAuto',
            $constantRepo->getConstant('SENDGRID_FROM_AUTO')
        );

        return $config;
    }
}
