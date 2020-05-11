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

namespace CosaVostra\LocaliseBundle\Importer;

interface ImporterInterface
{
    /**
     * The exporter file extension.
     *
     * @return string
     */
    public static function getExtension(): string;

    /**
     * Export translation with a given local and tag (domain).
     *
     * @param string $locale
     * @param string $tag
     *
     * @return string The full path of the translation file.
     */
    public function import(string $locale, string $tag): string;
}
