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

namespace CosaVostra\LocaliseBundle\Http;

class Request
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $tags = [];

    /**
     * @var array
     */
    protected $locales = [];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get project tags.
     *
     * @return array
     */
    public function getTags(): array
    {
        if (empty($this->tags)) {
            $this->tags = $this->client
                ->request('/tags')
                ->toArray();
        }

        return $this->tags;
    }

    /**
     * Get project locales.
     *
     * @return array
     */
    public function getLocales(): array
    {
        if (empty($this->locales)) {
            $this->locales = $this->client
                ->request('/locales')
                ->toArray();
        }

        return $this->locales;
    }

    /**
     * @param string $locale
     * @param string $tag
     * @param string $extension
     * @param string $format
     *
     * @return string
     */
    public function getTranslationContent(string $locale, string $tag, string $extension = 'yml', string $format = 'symfony'): string
    {
        return $this->client
            ->request("/export/locale/$locale.$extension", [
                'filter' => $tag,
                'format' => $format,
                'order'  => 'id' // Sort by translation id (helpful to explore yml files)
            ])
            ->getContent();
    }
}
