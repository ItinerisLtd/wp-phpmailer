<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer\Drivers;

use Itineris\WPPHPMailer\ConfigInterface;
use Itineris\WPPHPMailer\ConstantRepository;

interface DriverInterface
{
    public static function makeConfig(ConstantRepository $constantRepo): ConfigInterface;
}
