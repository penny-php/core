<?php

namespace PennyPHP\Core;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class CoreBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yaml');
        $builder
            ->registerForAutoconfiguration(GameObjectPrototypeInterface::class)
            ->addTag("game.object.prototype")
        ;
        $builder->registerForAutoconfiguration(InMemoryGameObjectInterface::class)
            ->addTag('game.object.in_memory')
        ;
        parent::loadExtension($config, $container, $builder);
    }

    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import(__DIR__ . '/../config/doctrine.yaml');
        parent::prependExtension($container, $builder);
    }
}