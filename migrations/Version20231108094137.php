<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108094137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, date_note DATE NOT NULL, note VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence ADD notes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687FFC56F556 FOREIGN KEY (notes_id) REFERENCES note (id)');
        $this->addSql('CREATE INDEX IDX_94D4687FFC56F556 ON competence (notes_id)');
        $this->addSql('ALTER TABLE etudiant ADD notes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3FC56F556 FOREIGN KEY (notes_id) REFERENCES note (id)');
        $this->addSql('CREATE INDEX IDX_717E22E3FC56F556 ON etudiant (notes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687FFC56F556');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3FC56F556');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP INDEX IDX_94D4687FFC56F556 ON competence');
        $this->addSql('ALTER TABLE competence DROP notes_id');
        $this->addSql('DROP INDEX IDX_717E22E3FC56F556 ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP notes_id');
    }
}
