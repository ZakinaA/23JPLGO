<?php

declare(strict_types=1);

namespace DoctrineMigrations\oldVersions;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231115100110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE instrument ADD marque_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE instrument ADD CONSTRAINT FK_3CBF69DD4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_3CBF69DD4827B9B2 ON instrument (marque_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instrument DROP FOREIGN KEY FK_3CBF69DD4827B9B2');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP INDEX IDX_3CBF69DD4827B9B2 ON instrument');
        $this->addSql('ALTER TABLE instrument DROP marque_id');
    }
}
