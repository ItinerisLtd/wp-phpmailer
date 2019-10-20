<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer\Drivers;

use Itineris\WPPHPMailer\Config;
use Itineris\WPPHPMailer\ConfigInterface;
use Itineris\WPPHPMailer\ConstantRepository;

class MailtrapDriver implements DriverInterface
{
    public static function makeConfig(ConstantRepository $constantRepo): ConfigInterface
    {
        $config = new Config();

        $config->set('auth', true);
        $config->set('host', 'smtp.mailtrap.io');
        $config->set('port', 2525);
        $config->set('protocol', 'tls');

        $config->set(
            'password',
            $constantRepo->getRequired('MAILTRAP_PASSWORD')
        );
        $config->set(
            'username',
            $constantRepo->getRequired('MAILTRAP_USERNAME')
        );

        return $config;
    }
}
