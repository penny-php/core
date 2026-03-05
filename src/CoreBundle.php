<?php

namespace PennyPHP\Core;

use PennyPHP\Core\GameObjectPrototype\GameObjectPrototypeInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class CoreBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
//        $container->import('../config/services.yaml');
        $container->services()->instanceof(GameObjectPrototypeInterface::class)->tag("game.object.prototype");
        parent::loadExtension($config, $container, $builder);
    }

    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yaml');
        $container->import(__DIR__ . '/../config/doctrine.yaml');

        parent::prependExtension($container, $builder);
    }
}