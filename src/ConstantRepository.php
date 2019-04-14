<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

use Itineris\WPPHPMailer\Exceptions\NotFoundException;

class ConstantRepository
{
    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function get(string $name)
    {
        // phpcs:ignore WordPressVIPMinimum.Constants.ConstantString.NotCheckingConstantName
        return defined($name)
            ? constant($name)
            : null;
    }

    /**
     * @param string $name
     *
     * @return mixed
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
