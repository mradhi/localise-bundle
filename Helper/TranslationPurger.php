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

use DirectoryIterator;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TranslationPurger
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
     * Remove all files in the translation directory.
     */
    public function purge(): void
    {
        $di = new RecursiveDirectoryIterator($this->parameterBag->get('translator.default_path'), FilesystemIterator::SKIP_DOTS);

        foreach (new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST) as $fileInfo) {
            if ($fileInfo->isDir()) {
                rmdir($fileInfo->getPathname());
                continue;
            }

            if (!$this->isDotFile($fileInfo->getBasename())) {
                unlink($fileInfo->getPathname());
            }
        }
    }

    private function isDotFile(string $basename): bool
    {
        return (substr($basename, 0, strlen('.')) === '.');
    }
}
