<?php

declare(strict_types=1);

namespace BaksDev\Article\Category;

use DirectoryIterator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class BaksDevArticleCategoryBundle extends AbstractBundle
{
    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder) : void
    {
        $path = __DIR__.'/Resources/config/';
        foreach(new DirectoryIterator($path) as $config)
        {
            if($config->isDot() || $config->isDir())
            {
                continue;
            }
            if($config->isFile() && $config->getExtension() === 'php' && $config->getFilename() !== 'routes.php')
            {
                $container->import($config->getPathname());
            }
        }
    }
}