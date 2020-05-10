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

namespace CosaVostra\LocaliseBundle;

use CosaVostra\LocaliseBundle\Exporter\Exception\InvalidExporterException;
use CosaVostra\LocaliseBundle\Exporter\Registry;
use CosaVostra\LocaliseBundle\Helper\TranslationPurger;
use CosaVostra\LocaliseBundle\Http\Request;

class LocaliseManager
{
    /**
     * @var Registry
     */
    protected $exporterRegistry;

    /**
     * @var Request
     */
    protected $localiseRequest;

    /**
     * @var TranslationPurger
     */
    protected $translationPurger;

    public function __construct(Registry $exporterRegistry, Request $localiseRequest, TranslationPurger $translationPurger)
    {
        $this->exporterRegistry  = $exporterRegistry;
        $this->localiseRequest   = $localiseRequest;
        $this->translationPurger = $translationPurger;
    }

    /**
     * @param string $extension
     * @param bool   $purge
     *
     * @throws InvalidExporterException
     */
    public function export(string $extension = 'yaml', bool $purge = false): void
    {
        $exporter = $this->exporterRegistry->get($extension);

        if ($purge) {
            $this->translationPurger->purge();
        }

        foreach ($this->localiseRequest->getTags() as $tag) {
            foreach ($this->localiseRequest->getLocales() as $locale) {
                $exporter->export($locale['code'], $tag);
            }
        }
    }
}
