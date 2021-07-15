<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer\Drivers;

use Itineris\WPPHPMailer\Config;
use Itineris\WPPHPMailer\ConfigInterface;
use Itineris\WPPHPMailer\ConstantRepository;

class SMTPDriver implements \Itineris\WPPHPMailer\Drivers\DriverInterface
{
    public static function makeConfig(ConstantRepository $constantRepo): ConfigInterface
    {
        $config = new Config();

        $config->set(
            'auth',
            $constantRepo->get('SMTP_AUTH') ?: true
        );

        $config->set(
            'host',
            $constantRepo->getRequired('SMTP_HOST')
        );

        $config->set(
            'port',
            $constantRepo->get('SMTP_PORT') ?: 587
        );

        $config->set(
            'protocol',
            $constantRepo->get('SMTP_PROTOCOL') ?: 'tls'
        );

        $config->set(
            'username',
            $constantRepo->getRequired('SMTP_USERNAME')
        );

        $config->set(
            'password',
            $constantRepo->getRequired('SMTP_PASSWORD')
        );

        $config->set(
            'fromAddress',
            $constantRepo->get('SMTP_FROM_ADDRESS')
        );

        $config->set(
            'fromName',
            $constantRepo->get('SMTP_FROM_NAME')
        );

        $config->set(
            'fromAuto',
            $constantRepo->get('SMTP_FROM_AUTO')
        );

        return $config;
    }
}
