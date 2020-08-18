# WP PHPMailer

[![CircleCI](https://circleci.com/gh/ItinerisLtd/wp-phpmailer.svg?style=svg)](https://circleci.com/gh/ItinerisLtd/wp-phpmailer)
[![Packagist Version](https://img.shields.io/packagist/v/itinerisltd/wp-phpmailer.svg?label=release&style=flat-square)](https://packagist.org/packages/itinerisltd/wp-phpmailer)
[![WordPress Plugin Rating](https://img.shields.io/wordpress/plugin/rating/wp-phpmailer?style=flat-square)](https://wordpress.org/plugins/wp-phpmailer)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/itinerisltd/wp-phpmailer.svg?style=flat-square)](https://packagist.org/packages/itinerisltd/wp-phpmailer)
[![WordPress Plugin: Tested WP Version](https://img.shields.io/wordpress/plugin/tested/wp-phpmailer?style=flat-square)](https://wordpress.org/plugins/wp-phpmailer)
[![Packagist Downloads](https://img.shields.io/packagist/dt/itinerisltd/wp-phpmailer.svg?label=packagist%20downloads&style=flat-square)](https://packagist.org/packages/itinerisltd/wp-phpmailer/stats)
[![WordPress Plugin Downloads](https://img.shields.io/wordpress/plugin/dt/wp-phpmailer?label=wp.org%20downloads&style=flat-square)](https://wordpress.org/plugins/wp-phpmailer/advanced/)
[![GitHub License](https://img.shields.io/github/license/itinerisltd/wp-phpmailer.svg?style=flat-square)](https://github.com/ItinerisLtd/wp-phpmailer/blob/master/LICENSE)
[![Hire Itineris](https://img.shields.io/badge/Hire-Itineris-ff69b4.svg?style=flat-square)](https://www.itineris.co.uk/contact/)
[![Twitter Follow @itineris_ltd](https://img.shields.io/twitter/follow/itineris_ltd?style=flat-square&color=1da1f2)](https://twitter.com/itineris_ltd)
[![Twitter Follow @TangRufus](https://img.shields.io/twitter/follow/TangRufus?style=flat-square&color=1da1f2)](https://twitter.com/tangrufus)


[WP PHPMailer](https://github.com/ItinerisLtd/wp-phpmailer) provides a clean and simple way to configure [the WordPress-bundled PHPMailer library](https://core.trac.wordpress.org/browser/trunk/src/wp-includes/class-phpmailer.php), allowing you to quickly get started sending mail through a local or cloud based service of your choice.

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Goal](#goal)
- [Usage](#usage)
  - [Mailhog](#mailhog)
  - [Mailtrap](#mailtrap)
  - [SendGrid](#sendgrid)
- [Custom Driver](#custom-driver)
  - [Step 1. Define Your Driver](#step-1-define-your-driver)
  - [Step 2. Register Your Driver](#step-2-register-your-driver)
  - [Step 3. Define Constants](#step-3-define-constants)
- [Filters](#filters)
  - [`wp_phpmailer_driver`](#wp_phpmailer_driver)
  - [`wp_phpmailer_drivers`](#wp_phpmailer_drivers)
  - [`wp_phpmailer_config_mappings`](#wp_phpmailer_config_mappings)
- [Minimum Requirements](#minimum-requirements)
- [Installation](#installation)
  - [Composer (Recommended)](#composer-recommended)
  - [wordpress.org (WP CLI)](#wordpressorg-wp-cli)
  - [wordpress.org](#wordpressorg)
  - [Build from Source (Not Recommended)](#build-from-source-not-recommended)
- [Common Errors](#common-errors)
  - [`NotFoundException` - `Driver 'xxx' not found, acceptable values are: aaa, bbb, ccc`](#notfoundexception---driver-xxx-not-found-acceptable-values-are-aaa-bbb-ccc)
- [FAQ](#faq)
  - [Where is the settings page?](#where-is-the-settings-page)
  - [Will you add a settings page?](#will-you-add-a-settings-page)
  - [What PHPMailer version bundled?](#what-phpmailer-version-bundled)
  - [Is it a must to use SMTP?](#is-it-a-must-to-use-smtp)
  - [Will you add support for older PHP versions?](#will-you-add-support-for-older-php-versions)
  - [It looks awesome. Where can I find more goodies like this?](#it-looks-awesome-where-can-i-find-more-goodies-like-this)
  - [Where can I give :star::star::star::star::star: reviews?](#where-can-i-give-starstarstarstarstar-reviews)
- [Testing](#testing)
- [Feedback](#feedback)
- [Change Log](#change-log)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Goal

Although WordPress bundles [the PHPMailer library](https://core.trac.wordpress.org/browser/trunk/src/wp-includes/class-phpmailer.php) which allow you sending mail through a local or cloud based service of your choice, different cloud based service requires different configuration.
Worse still, most services provide multiple ways for setting them up. For instance: which [SendGrid](https://sendgrid.com/) SMTP port provides the highest level of security, `25`, `587`, `2525` or `465`?

[WP PHPMailer](https://github.com/ItinerisLtd/wp-phpmailer) uses [the WordPress-bundled PHPMailer library](https://core.trac.wordpress.org/browser/trunk/src/wp-includes/class-phpmailer.php):

- so you offload the responsibility of updating bundled libraries from plugin authors to WordPress core team and contributors
  * at the time of writing, the official SendGrid plugin's [vendor folder](https://github.com/sendgrid/wordpress/tree/master/vendor) hasn't been updated in 2.5 years

[WP PHPMailer](https://github.com/ItinerisLtd/wp-phpmailer) believes in [convention over configuration](https://rubyonrails.org/doctrine/#convention-over-configuration), we pick the best configuration for each service:

- so you don't waste time going through the documents
- so you don't have to figure out which port and protocol to use
- so you don't miss any security configuration, e.g: `SMTPAuth`, `SMTPSecure`, etc
  * unlike [the official Mailgun plugin](https://wordpress.org/plugins/mailgun/), there is no "use secure SMTP" option because nobody should be using insecure options
- so you only have to provide minimum information
  * take SendGrid for example, only SendGrid API key (with "Mail Send" permission only) is required

[WP PHPMailer](https://github.com/ItinerisLtd/wp-phpmailer) believes a plugin should ["do one thing and do it well"](https://en.wikipedia.org/wiki/Unix_philosophy#Do_One_Thing_and_Do_It_Well):

- unlike [the official SendGrid plugin](https://wordpress.org/plugins/sendgrid-email-delivery-simplified/), [WP PHPMailer](https://github.com/ItinerisLtd/wp-phpmailer) doesn't include the subscription widget nor the stats dashboard

## Usage

Pick one driver and define its required constants in `wp-config.php`.

### Mailhog

```php
define('WP_PHPMAILER_DRIVER', 'mailhog');
```

### Mailtrap

```php
define('WP_PHPMAILER_DRIVER', 'mailtrap');

define('MAILTRAP_USERNAME', 'your-mailtrap-username');
define('MAILTRAP_PASSWORD', 'your-mailtrap-password');
```

### SendGrid

```php
define('WP_PHPMAILER_DRIVER', 'sendgrid');

define('SENDGRID_API_KEY', 'your-sendgrid-api-key');

// Optional. Useful if you have email authentication configurated.
define('SENDGRID_FROM_ADDRESS', 'you@example.test');
define('SENDGRID_FROM_NAME', 'John Doe');
define('SENDGRID_FROM_AUTO', true);
```

## Custom Driver

### Step 1. Define Your Driver

```php
class MyCustomDriver implements DriverInterface
{
    public static function makeConfig(ConstantRepository $constantRepo): ConfigInterface
    {
        $config = new Config();

        $config->set('auth', true);
        $config->set('host', 'smtp.custom.test');
        $config->set('port', 587);
        $config->set('protocol', 'tls');

        $config->set(
            'username',
            $constantRepo->getRequired('MY_CUSTOM_USERNAME')
        );

        $config->set(
            'password',
            $constantRepo->getRequired('MY_CUSTOM_PASSWORD')
        );

        $config->set(
            'fromAddress',
            $constantRepo->get('MY_CUSTOM_FROM_ADDRESS')
        );
        $config->set(
            'fromName',
            $constantRepo->get('MY_CUSTOM_FROM_NAME')
        );
        $config->set(
            'fromAuto',
            $constantRepo->get('MY_CUSTOM_FROM_AUTO')
        );

        return $config;
    }
}
```

### Step 2. Register Your Driver

```php
add_filter('wp_phpmailer_drivers', function (array $drivers): array {
    $drivers['my-custom-driver'] = MyCustomDriver::class;

    return $drivers;
});
```

### Step 3. Define Constants

```php
// wp-config.php

define('WP_PHPMAILER_DRIVER', 'my-custom-driver');

define('MY_CUSTOM_USERNAME', 'xxx');
define('MY_CUSTOM_PASSWORD', 'xxx');

// Optional.
define('MY_CUSTOM_FROM_ADDRESS', 'xxx');
define('MY_CUSTOM_FROM_NAME', 'xxx');
define('MY_CUSTOM_FROM_AUTO', true);
```

## Filters

### `wp_phpmailer_driver`

`$driver = (string) apply_filters('wp_phpmailer_driver', string $wpPhpmailerDriver))`

Filters the `WP_PHPMAILER_DRIVER` constant.

Parameters:

- $wpPhpmailerDriver
  * (_string_) the value of `WP_PHPMAILER_DRIVER` constant

### `wp_phpmailer_drivers`

`$drivers = (array) apply_filters('wp_phpmailer_drivers', array $drivers)`

Filters the available drivers array.

Parameters:

- $drivers
  * (_array_) the available drivers array

Example:

 ```php
add_filter('wp_phpmailer_drivers', function (array $drivers): array {
    $drivers['my-custom-driver'] = MyCustomDriver::class;

    return $drivers;
});
 ```

### `wp_phpmailer_config_mappings`

`$mappings = (array) apply_filters('wp_phpmailer_config_mappings', array $mapings)`

Filters the whitelisted PHPMailer configuration (property names) array.
'fromAddress', 'fromName', 'fromAuto' are special. Do not add them in mappings!

Parameters:

- $mapings
  * (_array_) the whitelisted PHPMailer configuration (property names)

Example:

```php
add_filter('wp_phpmailer_config_mappings', function (array $mappings): array {
    $mappings['xxx'] = 'yyy';

    return $mappings;
});

// The above filter results in:
add_action( 'phpmailer_init', function (PHPMailer $phpmailer) {
    // $this->config comes from `DriverInterface::makeConfig`.
    $phpmailer->xxx = $this->config->get('yyy');
});
```

## Minimum Requirements

- PHP v7.2
- WordPress v5.1

## Installation

### Composer (Recommended)

```bash
composer require itinerisltd/wp-phpmailer
```

### wordpress.org (WP CLI)

```bash
wp plugin install wp-phpmailer
```

### wordpress.org

Download from https://wordpress.org/plugins/wp-phpmailer
Then, install `wp-phpmailer.zip` [as usual](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

### Build from Source (Not Recommended)

```bash
# Make sure you use the same PHP version as remote servers.
# Building inside docker images is recommended.
php -v

# Checkout source code
git clone https://github.com/ItinerisLtd/wp-phpmailer.git
cd wp-phpmailer
git checkout <the-tag-or-the-branch-or-the-commit>

# Build the zip file
composer release:build
```

Then, install `release/wp-phpmailer.zip` [as usual](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

## Common Errors

### `NotFoundException` - `Driver 'xxx' not found, acceptable values are: aaa, bbb, ccc`

Reason: Driver is not found or not defined.

Troubleshooting:

- Ensure PHP constant is `WP_PHPMAILER_DRIVER` is correct
- Ensure filter `wp_phpmailer_driver` is functioning correctly

## FAQ

### Where is the settings page?

There is no settings page.

All configurations are done by [PHP constants](https://www.php.net/manual/en/language.constants.php) and [WordPress filters](#filters).

### Will you add a settings page?

No.

We have seen [countless](https://blog.sucuri.net/2019/03/0day-vulnerability-in-easy-wp-smtp-affects-thousands-of-sites.html) [vulnerabilities](https://www.pluginvulnerabilities.com/2016/04/04/when-full-disclosure-of-a-claimed-wordpress-plugin-vulnerability-leads-to-a-bigger-problem/) [related](https://www.wordfence.com/blog/2019/03/recent-social-warfare-vulnerability-allowed-remote-code-execution/) [to](https://www.wordfence.com/blog/2018/11/privilege-escalation-flaw-in-wp-gdpr-compliance-plugin-exploited-in-the-wild/) user inputs.
Mail settings don't change often and should be configured by a developer.
Therefore, [WP PHPMailer](https://github.com/ItinerisLtd/wp-phpmailer) decided to use PHP constants instead of storing options in WordPress database.

However, if you must, you can use [filters](#filters) to override this behavior.

### What PHPMailer version bundled?

This plugin reuse [the PHPMailer class bundled with WordPress core](https://core.trac.wordpress.org/browser/trunk/src/wp-includes/class-phpmailer.php).

Thus, you have to keep WordPress core up to date to receive security patches.

### Is it a must to use SMTP?

No.

While you can make your own non-SMTP drivers, all default drivers are using SMTP. Pull requests are welcomed.

### Will you add support for older PHP versions?

Never! This plugin will only work on [actively supported PHP versions](https://secure.php.net/supported-versions.php).

Don't use it on **end of life** or **security fixes only** PHP versions.

### It looks awesome. Where can I find more goodies like this?

- Articles on [Itineris' blog](https://www.itineris.co.uk/blog/)
- More projects on [Itineris' GitHub profile](https://github.com/itinerisltd)
- More plugins on [Itineris](https://profiles.wordpress.org/itinerisltd/#content-plugins) and [TangRufus](https://profiles.wordpress.org/tangrufus/#content-plugins) wp.org profiles
- Follow [@itineris_ltd](https://twitter.com/itineris_ltd) and [@TangRufus](https://twitter.com/tangrufus) on Twitter
- Hire [Itineris](https://www.itineris.co.uk/services/) to build your next awesome site

### Where can I give :star::star::star::star::star: reviews?

Thanks! Glad you like it. It's important to let my boss knows somebody is using this project. Please consider:

- leave a 5-star review on [wordpress.org](https://wordpress.org/support/plugin/wp-phpmailer/reviews/)
- tweet something good with mentioning [@itineris_ltd](https://twitter.com/itineris_ltd) and [@TangRufus](https://twitter.com/tangrufus)
- :star: star this [Github repo](https://github.com/ItinerisLtd/wp-phpmailer)
- :eyes: watch this [Github repo](https://github.com/ItinerisLtd/wp-phpmailer)
- write blog posts
- submit [pull requests](https://github.com/ItinerisLtd/wp-phpmailer)
- [hire Itineris](https://www.itineris.co.uk/services/)

## Testing

```sh-session
composer test
composer phpstan:analyse
composer style:check
```

Pull requests without tests will not be accepted!

## Feedback

**Please provide feedback!** We want to make this library useful in as many projects as possible.
Please submit an [issue](https://github.com/ItinerisLtd/wp-phpmailer/issues/new) and point out what you do and don't like, or fork the project and make suggestions.
**No issue is too small.**

## Security

If you discover any security related issues, please email [dev@itineris.co.uk](mailto:dev@itineris.co.uk) instead of using the issue tracker.

## Credits

[WP PHPMailer](https://github.com/ItinerisLtd/wp-phpmailer) is a [Itineris Limited](https://www.itineris.co.uk/) project created by [Tang Rufus](https://typist.tech).

Special thanks to [Brandon](https://log1x.com/) whose [WP SMTP](https://github.com/Log1x/wp-smtp) inspired this project.

Full list of contributors can be found [here](https://github.com/ItinerisLtd/wp-phpmailer/graphs/contributors).

## License

[WP PHPMailer](https://github.com/ItinerisLtd/wp-phpmailer) is released under the [MIT License](https://opensource.org/licenses/MIT).
