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

namespace CosaVostra\LocaliseBundle\DependencyInjection\Compiler;

use CosaVostra\LocaliseBundle\Exporter\Registry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ExporterRegistryPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $exporters = $container->findTaggedServiceIds('localise.exporter');
        $registry = $container->getDefinition(Registry::class);

        foreach ($exporters as $class => $attrs) {
            $registry->addMethodCall('add', [new Reference($class)]);
        }
    }
}
