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

use CosaVostra\LocaliseBundle\Helper\FilenameGenerator;
use CosaVostra\LocaliseBundle\Http\Request;
use Symfony\Component\Filesystem\Filesystem;

class XlfImporter implements ImporterInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var FilenameGenerator
     */
    protected $filenameGenerator;

    public function __construct(Request $request, Filesystem $filesystem, FilenameGenerator $filenameGenerator)
    {
        $this->request           = $request;
        $this->filesystem        = $filesystem;
        $this->filenameGenerator = $filenameGenerator;
    }

    /**
     * @inheritDoc
     */
    public static function getExtension(): string
    {
        return 'xlf';
    }

    /**
     * @inheritDoc
     */
    public function import(string $locale, string $tag): string
    {
        $this->filesystem->dumpFile(
            $path = $this->filenameGenerator->getFilename($tag, $locale, static::getExtension()),
            $this->request->getTranslationContent($locale, $tag, 'xlf', 'symfony')
        );

        return $path;
    }
}
