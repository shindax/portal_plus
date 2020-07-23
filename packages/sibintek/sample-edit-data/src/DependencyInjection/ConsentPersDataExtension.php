<?php

namespace Sibintek\ConsentPersData\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Sibintek\ConsentPersData\Command\InstallCommand;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Console\Input\InputArgument;

class ConsentPersDataExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
//        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
//        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        // создание определения команды
        $commandDefinition = new Definition(InstallCommand::class);
        // регистрация сервиса команды как консольной команды
        $commandDefinition->addTag('console.command', ['command' => InstallCommand::getDefaultName()]);
        // установка определения в контейнер
        $container->setDefinition(InstallCommand::class, $commandDefinition);
        $commandDefinition->setAutoconfigured(true);
        $commandDefinition->addArgument(new Reference('filesystem'));
        $commandDefinition->addArgument(new Reference('doctrine.dbal.default_connection'));
        $commandDefinition->addArgument('%kernel.project_dir%');
    }

    public function getAlias()
    {
        return 'sibintek_pers_data';
    }
}
