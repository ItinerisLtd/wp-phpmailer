<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use Itineris\WPPHPMailer\Exceptions\NotFoundException;
use Itineris\WPPHPMailer\Util\Str;

class ConstantRepository
{
    /**
     * @param string $name Name of the constant.
     *
     * @return mixed|null
     */
    public function get(string $name)
    {
        $key = Str::screamingSnake($name);

        // phpcs:ignore WordPressVIPMinimum.Constants.ConstantString.NotCheckingConstantName
        $value = defined($key)
            ? constant($key)
            : null;

        return apply_filters(
            Str::snake($name),
            $value
        );
    }

    /**
     * @param string $name Name of the constant.
     *
     * @return mixed
     *
     * @throws NotFoundException If constant not defined.
     */
    public function getRequired(string $name)
    {
        $constant = $this->get($name);
        if (null === $constant) {
            $message = sprintf(
                'Required constant \'%1$s\' not found. Please define it in wp-config.php.',
                $name
            );

            throw new NotFoundException($message);
        }

        return $constant;
    }
}
