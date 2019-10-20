<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer\Drivers;

use Itineris\WPPHPMailer\Config;
use Itineris\WPPHPMailer\ConfigInterface;
use Itineris\WPPHPMailer\ConstantRepository;

class MailHogDriver implements DriverInterface
{
    public static function makeConfig(ConstantRepository $constantRepo): ConfigInterface
    {
        $config = new Config();

        $config->set('host', '127.0.0.1');
        $config->set('port', 1025);

        return $config;
    }
}
