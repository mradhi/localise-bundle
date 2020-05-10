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

use Locale;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FilenameGenerator
{
    /**
     * @var ParameterBagInterface
     */
    protected $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    /**
     * Get the full translation filename.
     *
     * @param string $domain
     * @param string $locale
     * @param string $extension
     *
     * @return string
     */
    public function getFilename(string $domain, string $locale, string $extension): string
    {
        return $this->parameterBag->get('translator.default_path') . '/' . $this->getName($domain, $locale, $extension);
    }

    /**
     * Returns safe translation filename.
     *
     * @param string $domain
     * @param string $locale
     * @param string $extension
     *
     * @return string
     */
    protected function getName(string $domain, string $locale, string $extension): string
    {
        return StringFormatter::toSnake($domain) . '.' . Locale::canonicalize($locale) . '.' . $extension;
    }
}
