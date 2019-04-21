# WP PHPMailer

[![CircleCI](https://circleci.com/gh/ItinerisLtd/wp-phpmailer.svg?style=svg)](https://circleci.com/gh/ItinerisLtd/wp-phpmailer)
[![Packagist Version](https://img.shields.io/packagist/v/itinerisltd/wp-phpmailer.svg)](https://packagist.org/packages/itinerisltd/wp-phpmailer)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/itinerisltd/wp-phpmailer.svg)](https://packagist.org/packages/itinerisltd/wp-phpmailer)
[![Packagist Downloads](https://img.shields.io/packagist/dt/itinerisltd/wp-phpmailer.svg)](https://packagist.org/packages/itinerisltd/wp-phpmailer)
[![GitHub License](https://img.shields.io/github/license/itinerisltd/wp-phpmailer.svg)](https://github.com/ItinerisLtd/wp-phpmailer/blob/master/LICENSE)
[![Hire Itineris](https://img.shields.io/badge/Hire-Itineris-ff69b4.svg)](https://www.itineris.co.uk/contact/)


<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Goal](#goal)
- [Minimum Requirements](#minimum-requirements)
- [Installation](#installation)
  - [Composer (Recommended)](#composer-recommended)
  - [Classic](#classic)
- [Usage](#usage)
- [FAQ](#faq)
  - [Will you add support for older PHP versions?](#will-you-add-support-for-older-php-versions)
  - [It looks awesome. Where can I find some more goodies like this?](#it-looks-awesome-where-can-i-find-some-more-goodies-like-this)
  - [Besides wp.org, where can I give a :star::star::star::star::star: review?](#besides-wporg-where-can-i-give-a-starstarstarstarstar-review)
- [Testing](#testing)
- [Feedback](#feedback)
- [Change Log](#change-log)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Goal

## Minimum Requirements

- PHP v7.2
- WordPress v5.1

## Installation

### Composer (Recommended)

```sh-session
composer require itinerisltd/wp-phpmailer
```

### Build from Source

```sh-session
# Make sure you use the same PHP version as remote servers.
php -v

# Checkout source code
git clone https://github.com/ItinerisLtd/wp-phpmailer.git
cd wp-phpmailer
git checkout <the-tag-or-the-branch-or-the-commit>

# Build the zip file
composer release:build
```

Then, install `release/wp-phpmailer.zip` [as usual](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

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

## Common Errors

### `NotFoundException` - `Driver 'xxx' not found, acceptable values are: aaa, bbb, ccc`

Reason: Driver is not found or not defined.

Troubleshooting:

- Ensure PHP constant is `WP_PHPMAILER_DRIVER` is correct
- Ensure filter `wp_phpmailer_driver` is functioning correctly

## FAQ

### Where is the settings page?

There is no settings page. 

All configurations are done by [PHP constants](https://www.php.net/manual/en/language.constants.php) and [WordPress filters](https://codex.wordpress.org/Plugin_API/Filter_Reference).

### What PHPMailer version bundled?

This plugin reuse [the PHPMailer class bundled with WordPress core](https://core.trac.wordpress.org/browser/trunk/src/wp-includes/class-phpmailer.php).

Thus, you have to keep WordPress core up to date to receive security patches.

### Is it a must to use SMTP?

No. 

While you can make your own non-SMTP drivers, all default drivers are using SMTP. Pull requests are welcomed.

### Will you add support for older PHP versions?

Never! This plugin will only works on [actively supported PHP versions](https://secure.php.net/supported-versions.php).

Don't use it on **end of life** or **security fixes only** PHP versions.

### It looks awesome. Where can I find some more goodies like this?

- Articles on [Itineris' blog](https://www.itineris.co.uk/blog/)
- More projects on [Itineris' GitHub profile](https://github.com/itinerisltd)
- More plugins on [Itineris](https://profiles.wordpress.org/itinerisltd/#content-plugins) and [TangRufus](https://profiles.wordpress.org/tangrufus/#content-plugins) wp.org profiles
- Follow [@itineris_ltd](https://twitter.com/itineris_ltd) and [@TangRufus](https://twitter.com/tangrufus) on Twitter
- Hire [Itineris](https://www.itineris.co.uk/services/) to build your next awesome site

### Besides wp.org, where can I give a :star::star::star::star::star: review?

Thanks! Glad you like it. It's important to let my boss knows somebody is using this project. Please consider:

- give :star::star::star::star::star: reviews on [wp.org](https://wordpress.org/support/plugin/wp-phpmailer/reviews/#new-post)
- tweet something good with mentioning [@itineris_ltd](https://twitter.com/itineris_ltd) and [@TangRufus](https://twitter.com/tangrufus)
- ️️:star: star this [Github repo](https://github.com/ItinerisLtd/wp-phpmailer)
- watch this [Github repo](https://github.com/ItinerisLtd/wp-phpmailer)
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

## Change Log

Please see [CHANGELOG](./CHANGELOG.md) for more information on what has changed recently.

## Security

If you discover any security related issues, please email [hello@itineris.co.uk](hello@itineris.co.uk) instead of using the issue tracker.

## Credits

[WP PHPMailer](https://github.com/ItinerisLtd/wp-phpmailer) is a [Itineris Limited](https://www.itineris.co.uk/) project created by [Tang Rufus](https://typist.tech).

Special thanks to [Brandon](https://log1x.com/) whose [WP SMTP](https://github.com/Log1x/wp-smtp) inspired this project.

Full list of contributors can be found [here](https://github.com/ItinerisLtd/wp-phpmailer/graphs/contributors).

## License

[WP PHPMailer](https://github.com/ItinerisLtd/wp-phpmailer) is released under the [MIT License](https://opensource.org/licenses/MIT).
