<?php
/**
 * This file is part of the CosaVostra, Localise.biz bundle.
 *
 * (c) Mohamed Radhi GUENNICHI <rg@mate.tn> <+216 50 711 816>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace CosaVostra\LocaliseBundle\Helper;

class StringFormatter
{
    /**
     * Forked from symfony/string component.
     *
     * @param string $value
     *
     * @return string
     */
    public static function toCamel(string $value): string
    {
        return lcfirst(str_replace(' ', '', ucwords(preg_replace('/[^a-zA-Z0-9\x7f-\xff]++/', ' ', $value))));
    }

    /**
     * Forked from symfony/string component.
     *
     * @param string $value
     *
     * @return string
     */
    public static function toSnake(string $value): string
    {
        return strtolower(preg_replace(['/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'], '\1_\2', ucfirst(static::toCamel($value))));
    }
}
