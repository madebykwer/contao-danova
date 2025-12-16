<?php

namespace Madebykwer\ContaoDanova;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\CoreBundle\ContaoCoreBundle;

class MadebykwerContaoDanovaBundle extends Bundle implements BundlePluginInterface
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/Resources/config')
        );

        $loader->load('services.yaml');
    }

    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(self::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
