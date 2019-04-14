<?php
declare(strict_types=1);

namespace Itineris\WPPHPMailer;

class ConstantRepository
{
    public function getConstant(string $name)
    {
        return defined($name)
            ? constant($name)
            : null;
    }

    public function getRequiredConstant(string $name)
    {
        $constant = $this->getConstant($name);
        if (null === $constant) {
            // TODO!
            wp_die('todo');
        }

        return $constant;
    }
}
