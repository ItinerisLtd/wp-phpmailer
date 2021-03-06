<?php

declare(strict_types=1);

namespace Itineris\WPPHPMailer\Util;

class Str
{
    /**
     * The cache of screaming-snake-cased words.
     *
     * @var array<string, array<string, string>>
     */
    protected static $screamingSnakeCache = [];

    public static function screamingSnake(string $value): string
    {
        $delimiter = '_';
        $key = $value;

        if (! is_string(static::$screamingSnakeCache[$key][$delimiter] ?? null)) {
            $value = mb_strtoupper($value, 'UTF-8');
            $value = preg_replace('/[^\w]+/u', $delimiter, $value);

            static::$screamingSnakeCache[$key][$delimiter] = $value;
        }

        return static::$screamingSnakeCache[$key][$delimiter];
    }

    public static function snake(string $value): string
    {
        return mb_strtolower(
            static::screamingSnake($value),
            'UTF-8'
        );
    }
}
