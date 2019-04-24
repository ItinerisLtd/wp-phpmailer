<?php
/**
 * Plugin Name:     WP PHPMailer
 * Plugin URI:      https://github.com/ItinerisLtd/wp-phpmailer
 * Description:     WP PHPMailer provides a clean, simple way to configure WordPress-bundled PHPMailer library, allowing you to quickly get started sending mail through a local or cloud based service of your choice.
 * Version:         0.1.0
 * Author:          Itineris Limited
 * Author URI:      https://itineris.co.uk
 * License:         MIT
 * License URI:     https://opensource.org/licenses/MIT
 * Text Domain:     wp-phpmailer
 */

declare(strict_types=1);

namespace Itineris\WPPHPMailer;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

Plugin::run();
