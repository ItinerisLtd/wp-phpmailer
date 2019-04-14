<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer\Drivers;

use Itineris\WPPHPMailer\Config;
use Itineris\WPPHPMailer\ConfigInterface;
use Itineris\WPPHPMailer\ConstantRepository;

class SendGridDriver implements DriverInterface
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
            $constantRepo->getRequired('SENDGRID_API_KEY')
        );

        $config->set(
            'fromAddress',
            $constantRepo->get('SENDGRID_FROM_ADDRESS')
        );
        $config->set(
            'fromName',
            $constantRepo->get('SENDGRID_FROM_NAME')
        );
        $config->set(
            'fromAuto',
            $constantRepo->get('SENDGRID_FROM_AUTO')
        );

        return $config;
    }
}
