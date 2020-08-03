<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200728114723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');

        $this->addSql('ALTER TABLE feature ADD feature VARCHAR(255)');
        $this->addSql('ALTER TABLE feature DROP feature');
        $this->addSql('ALTER TABLE feature ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE product ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE product ALTER name TYPE TEXT');
        $this->addSql('ALTER TABLE product ALTER name DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {}
}
