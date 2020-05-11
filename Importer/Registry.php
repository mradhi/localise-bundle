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

use CosaVostra\LocaliseBundle\Importer\Exception\InvalidExporterException;

class Registry
{
    /**
     * @var ImporterInterface[]
     */
    protected $exporters = [];

    public function add(ImporterInterface $exporter): void
    {
        $this->exporters[$exporter->getExtension()] = $exporter;
    }

    public function get(string $extension): ImporterInterface
    {
        if (!array_key_exists($extension, $this->exporters)) {
            throw new InvalidExporterException("Exporter with the extension \"$extension\" is not supported.");
        }

        return $this->exporters[$extension];
    }
}
