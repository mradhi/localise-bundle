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

namespace CosaVostra\LocaliseBundle\Command;

use CosaVostra\LocaliseBundle\Exporter\Exception\InvalidExporterException;
use CosaVostra\LocaliseBundle\Exporter\Registry;
use CosaVostra\LocaliseBundle\Helper\TranslationPurger;
use CosaVostra\LocaliseBundle\Http\Request;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TranslationExportCommand extends Command
{
    protected static $defaultName = 'localise:translation:export';

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var TranslationPurger
     */
    protected $purger;

    public function __construct(Registry $registry, Request $request, TranslationPurger $purger)
    {
        $this->registry = $registry;
        $this->request  = $request;
        $this->purger   = $purger;

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setDescription('Export translations from localise.biz')
            ->addOption('extension', 'ext', InputOption::VALUE_OPTIONAL, 'The extension of the translation file (yaml, php, xlf)')
            ->addOption('purge', 'p', InputOption::VALUE_NONE, 'Purge translation directory (remove old translations).');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $exporter = $this->registry->get($input->getOption('extension') ?? 'yaml');
        } catch (InvalidExporterException $exception) {
            $io->error($exception->getMessage());
            return 1;
        }

        if ($input->getOption('purge')) {
            $io->comment('Purging translation directory...');
            $this->purger->purge();
        }

        $io->comment('Exporting translations from localise.biz...');

        foreach ($this->request->getTags() as $tag) {
            foreach ($this->request->getLocales() as $locale) {
                $exporter->export($locale['code'], $tag);
                // TODO: print information about the exported file path?
            }
        }

        $this->printStats($io);

        $io->success('The translations was successfully exported.');

        return 0;
    }

    protected function printStats(SymfonyStyle $io): void
    {
        $stats = [];

        foreach ($this->request->getLocales() as $locale) {
            $name         = $locale['name'];
            $code         = $locale['code'];
            $translated   = $locale['progress']['translated'];
            $untranslated = $locale['progress']['untranslated'];

            if ($untranslated > 0) {
                $untranslated = "<options=bold;fg=red>$untranslated</>";
            } else {
                $untranslated = "<options=bold;fg=green>$untranslated</>";
            }

            $stats[] = ["$name", "$code", "<options=bold>$translated</>", "$untranslated"];
        }

        $io->table(['Name', 'Code', 'Translated', 'Untranslated'], $stats);
    }
}
