<?php

namespace Sibintek\ConsentPersData\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\DBAL\Driver\Connection;


class InstallCommand extends Command
{
    protected static $defaultName = 'sibintek:ConsentPersData:install';

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
//            ->setName('sibintek:ConsentPersData:install')

            ->setDescription('Creating tables in the database.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command creating tables in the database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Installing sibintek/ConsentPersDatarBundle...');

        $this->initConfig($output);
        $this->initConfigRoutes($output);
        $this->initDataBase($output);
        return 0;
    }

    private function initConfigRoutes(OutputInterface $output): void
    {
        // Create default config if not exists
        $bundleConfigFilename = $this->projectDir
            . DIRECTORY_SEPARATOR . 'config'
            . DIRECTORY_SEPARATOR . 'routes'
            . DIRECTORY_SEPARATOR . 'consentpersdata.yaml'
        ;
        if ($this->filesystem->exists($bundleConfigFilename)) {
            $output->writeln('Config file already exists');

            return;
        }

        $config = <<<YAML
# \\config\\routes\\consentpersdata.yaml
app_controllers:
    resource: '@ConsentPersDataBundle/Controller/'
    type: annotation
YAML;
        $this->filesystem->appendToFile($bundleConfigFilename, $config);

        $output->writeln('Config created: "config/routes/consentpersdata.yaml"');

    }

    private function initConfig(OutputInterface $output): void
    {
        // Create default config if not exists
        $bundleConfigFilename = $this->projectDir
            . DIRECTORY_SEPARATOR . 'config'
            . DIRECTORY_SEPARATOR . 'packages'
            . DIRECTORY_SEPARATOR . 'consentpersdata.yaml'
        ;
        if ($this->filesystem->exists($bundleConfigFilename)) {
            $output->writeln('Config file already exists');

            return;
        }

        $config = <<<YAML
# \\config\\packages\\consentpersdata.yaml
sibintek_pers_data:
    storage: 'c:\\temp\\storage'

services:
    # default configuration for services in *this* file
    _defaults:
        autowire: true      # Automatically injects dependencies in your services.
        autoconfigure: true # Automatically registers your services as commands, event subscribers, etc.

    app_controller:
        namespace: Sibintek\\ConsentPersData\\Controller\\
        resource: '@ConsentPersDataBundle/Controller'
        tags: ['controller.service_arguments']

    Sibintek\\ConsentPersData\\Repository\\CandidateRepository: ~
    Sibintek\\ConsentPersData\\Repository\\EmailAddressRepository: ~
    Sibintek\\ConsentPersData\\Repository\\MessageEmailRepository: ~
    Sibintek\\ConsentPersData\\Repository\\AttachmentRepository: ~
    Sibintek\\ConsentPersData\\Repository\\FeedbackRepository: ~

    Sibintek\\ConsentPersData\\Service\\FileUploader:
        arguments:
            \$targetDirectory: 'upload_dir'
YAML;
        $this->filesystem->appendToFile($bundleConfigFilename, $config);

        $output->writeln('Config created: "config/packages/consentpersdata.yaml"');

    }

    private function initDataBase(OutputInterface $output): void
    {
//        MySQL
/*        $sql = "DROP TABLE IF EXISTS `pd_feedback`;CREATE TABLE IF NOT EXISTS `pd_feedback` (`id` int NOT NULL AUTO_INCREMENT,`email_addresses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',`subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,`body` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,`files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:array)',`date_time_sent` datetime DEFAULT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1;
                DROP TABLE IF EXISTS `pd_candidate`;CREATE TABLE IF NOT EXISTS `pd_candidate` (`id` int NOT NULL AUTO_INCREMENT,`last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,`first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,`patronymic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,`birthday` date DEFAULT NULL,`isconsent` tinyint(1) NOT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1;
                DROP TABLE IF EXISTS `pd_email_address`;CREATE TABLE IF NOT EXISTS `pd_email_address` (`id` int NOT NULL AUTO_INCREMENT,`candidate_id` int DEFAULT NULL,`name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,`isspam` tinyint(1) NOT NULL,`isnoreply` tinyint(1) NOT NULL,`dateregistration` datetime DEFAULT NULL,`datesent` datetime DEFAULT NULL,PRIMARY KEY (`id`),KEY `IDX_35FAE66B91BD8781` (`candidate_id`),CONSTRAINT `FK_35FAE66B91BD8781` FOREIGN KEY (`candidate_id`) REFERENCES `pd_candidate` (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1;
                DROP TABLE IF EXISTS `pd_message_email`;CREATE TABLE IF NOT EXISTS `pd_message_email` (`id` int NOT NULL AUTO_INCREMENT,`sender_id` int NOT NULL,`subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,`body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,`date_time_received` datetime NOT NULL,`date_time_sent` datetime NOT NULL,`is_attachment` tinyint(1) NOT NULL,PRIMARY KEY (`id`),KEY `IDX_9D4062BAF624B39D` (`sender_id`),CONSTRAINT `FK_9D4062BAF624B39D` FOREIGN KEY (`sender_id`) REFERENCES `pd_email_address` (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1; commit ;
                DROP TABLE IF EXISTS `pd_attachment`;CREATE TABLE IF NOT EXISTS `pd_attachment` (`id` int NOT NULL AUTO_INCREMENT,`message_email_id` int NOT NULL,`file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,`drive` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,`path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,`origin_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,PRIMARY KEY (`id`),KEY `IDX_EF47F55EA11405D8` (`message_email_id`),CONSTRAINT `FK_pd_attachment_pd_message_email` FOREIGN KEY (`message_email_id`) REFERENCES `pd_message_email` (`id`)) ENGINE=InnoDB AUTO_INCREMENT=1;";*/
//      PostgfreSQL
        $sql[] = 'CREATE SEQUENCE pd_attachment_id_seq INCREMENT BY 1 MINVALUE 1 START 1;';
        $sql[] = 'CREATE SEQUENCE pd_candidate_id_seq INCREMENT BY 1 MINVALUE 1 START 1';
        $sql[] = 'CREATE SEQUENCE pd_email_address_id_seq INCREMENT BY 1 MINVALUE 1 START 1';
        $sql[] = 'CREATE SEQUENCE pd_feedback_id_seq INCREMENT BY 1 MINVALUE 1 START 1';
        $sql[] = 'CREATE SEQUENCE pd_message_email_id_seq INCREMENT BY 1 MINVALUE 1 START 1';
        $sql[] = 'CREATE TABLE pd_attachment (id INT NOT NULL, message_email_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, drive VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, origin_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))';
        $sql[] = 'CREATE INDEX IDX_EF47F55EA11405D8 ON pd_attachment (message_email_id)';
        $sql[] = 'CREATE TABLE pd_candidate (id INT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, patronymic VARCHAR(255) DEFAULT NULL, birthday DATE DEFAULT NULL, isconsent BOOLEAN NOT NULL, PRIMARY KEY(id))';
        $sql[] = 'CREATE TABLE pd_email_address (id INT NOT NULL, candidate_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, isspam BOOLEAN NOT NULL, isnoreply BOOLEAN NOT NULL, datesent TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, dateregistration TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))';
        $sql[] = 'CREATE INDEX IDX_35FAE66B91BD8781 ON pd_email_address (candidate_id)';
        $sql[] = 'CREATE TABLE pd_feedback (id INT NOT NULL, email_addresses TEXT NOT NULL, subject VARCHAR(255) DEFAULT NULL, body VARCHAR(1000) DEFAULT NULL, files TEXT DEFAULT NULL, date_time_sent TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))';
        $sql[] = 'COMMENT ON COLUMN pd_feedback.email_addresses IS \'(DC2Type:array)\'';
        $sql[] = 'COMMENT ON COLUMN pd_feedback.files IS \'(DC2Type:array)\'';
        $sql[] = 'CREATE TABLE pd_message_email (id INT NOT NULL, sender_id INT NOT NULL, subject VARCHAR(255) DEFAULT NULL, body TEXT DEFAULT NULL, date_time_received TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_time_sent TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_attachment BOOLEAN NOT NULL, PRIMARY KEY(id))';
        $sql[] = 'CREATE INDEX IDX_9D4062BAF624B39D ON pd_message_email (sender_id)';
        $sql[] = 'ALTER TABLE pd_attachment ADD CONSTRAINT FK_EF47F55EA11405D8 FOREIGN KEY (message_email_id) REFERENCES pd_message_email (id) NOT DEFERRABLE INITIALLY IMMEDIATE';
        $sql[] = 'ALTER TABLE pd_email_address ADD CONSTRAINT FK_35FAE66B91BD8781 FOREIGN KEY (candidate_id) REFERENCES pd_candidate (id) NOT DEFERRABLE INITIALLY IMMEDIATE';
        $sql[] = 'ALTER TABLE pd_message_email ADD CONSTRAINT FK_9D4062BAF624B39D FOREIGN KEY (sender_id) REFERENCES pd_email_address (id) NOT DEFERRABLE INITIALLY IMMEDIATE';

        try {
            foreach ($sql as $item )
            $this->connection->exec($item);
        } catch (Exception $e) {
            $output->writeln('Error: ' .  $e->getMessage() . "\n");
        }
        $output->writeln('Database table created.');
    }
}