<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer\Drivers;

use Itineris\WPPHPMailer\Config;
use Itineris\WPPHPMailer\ConfigInterface;
use Itineris\WPPHPMailer\ConstantRepository;

class Office365Driver implements DriverInterface
{
    public static function makeConfig(ConstantRepository $constantRepo): ConfigInterface
    {
        $config = new Config();

        $config->set('auth', true);
        $config->set('host', 'smtp.office365.com');
        $config->set('port', 587);
        $config->set('protocol', 'tls');

        $config->set(
            'username',
            $constantRepo->getRequired('OFFICE_USERNAME')
        );

        $config->set(
            'password',
            $constantRepo->getRequired('OFFICE_PASSWORD')
        );

        $config->set(
            'fromAddress',
            $constantRepo->get('OFFICE_FROM_ADDRESS')
        );
        $config->set(
            'fromName',
            $constantRepo->get('OFFICE_FROM_NAME')
        );
        $config->set(
            'fromAuto',
            $constantRepo->get('OFFICE_FROM_AUTO')
        );

        return $config;
    }
}
