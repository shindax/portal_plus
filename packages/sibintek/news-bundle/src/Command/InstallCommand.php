<?php

namespace Sibintek\NewsBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\DBAL\Driver\Connection;

class InstallCommand extends Command
{
    protected static $defaultName = 'sibintek:news:install';
    /** @var Filesystem */
    private $filesystem;
    private $projectDir;

    public function __construct(Filesystem $filesystem, Connection $connection, string $projectDir)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
        $this->projectDir = $projectDir;
        $this->connection = $connection;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creating tables in the database.')
            ->setHelp('This command creating tables in the database')
        ;
    }

        protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Installing sibintek/NewsBundle...');

        $this->initConfig($output);
        $this->initConfigRoutes($output);
        // $this->initDataBase($output);
        return 0;
    }

    private function initConfigRoutes(OutputInterface $output): void
    {
        // Create default config if not exists
        $bundleConfigFilename = $this->projectDir
            . DIRECTORY_SEPARATOR . 'config'
            . DIRECTORY_SEPARATOR . 'routes'
            . DIRECTORY_SEPARATOR . 'news.yaml'
        ;
        if ($this->filesystem->exists($bundleConfigFilename)) {
            $output->writeln('Config file already exists');

            return;
        }

        $config = <<<YAML
# \\config\\routes\\news.yaml
app_controllers:
    resource: '@NewsBundle/Controller/'
    type: annotation
YAML;
        $this->filesystem->appendToFile($bundleConfigFilename, $config);

        $output->writeln('Config created: "config/routes/news.yaml"');

    }

    private function initConfig(OutputInterface $output): void
    {
        // Create default config if not exists
        $bundleConfigFilename = $this->projectDir
            . DIRECTORY_SEPARATOR . 'config'
            . DIRECTORY_SEPARATOR . 'packages'
            . DIRECTORY_SEPARATOR . 'news.yaml'
        ;
        if ($this->filesystem->exists($bundleConfigFilename)) {
            $output->writeln('Config file already exists');

            return;
        }

        $config = <<<YAML
# \\config\\packages\\news.yaml
news:
    storage: 'c:\\temp\\storage'

services:
    # default configuration for services in *this* file
    _defaults:
        autowire: true      # Automatically injects dependencies in your services.
        autoconfigure: true # Automatically registers your services as commands, event subscribers, etc.

    app_controller:
        namespace: Sibintek\\NewsBundle\\Controller\\
        resource: '@NewsBundle/Controller'
        tags: ['controller.service_arguments']

    Sibintek\\NewsBundle\\Repository\\OrgNewsRepository:
        tags: ['doctrine.repository_service']


YAML;
        $this->filesystem->appendToFile($bundleConfigFilename, $config);

        $output->writeln('Config created: "config/packages/news.yaml"');

    }

}