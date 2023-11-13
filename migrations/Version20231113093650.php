<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231113093650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, notes_id INT DEFAULT NULL, code VARCHAR(20) NOT NULL, libelle VARCHAR(50) NOT NULL, nb_etudiants_max VARCHAR(20) NOT NULL, INDEX IDX_94D4687FFC56F556 (notes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence_professeur (competence_id INT NOT NULL, professeur_id INT NOT NULL, INDEX IDX_3925EA6E15761DAB (competence_id), INDEX IDX_3925EA6EBAB22EE9 (professeur_id), PRIMARY KEY(competence_id, professeur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, maison_id INT DEFAULT NULL, notes_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, date_naiss DATE NOT NULL, ville VARCHAR(70) NOT NULL, numrue VARCHAR(20) NOT NULL, surnom VARCHAR(50) NOT NULL, copos VARCHAR(50) NOT NULL, rue VARCHAR(70) NOT NULL, INDEX IDX_717E22E39D67D8AF (maison_id), INDEX IDX_717E22E3FC56F556 (notes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maison (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(20) NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, date_note DATE NOT NULL, note VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, date_naiss DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687FFC56F556 FOREIGN KEY (notes_id) REFERENCES note (id)');
        $this->addSql('ALTER TABLE competence_professeur ADD CONSTRAINT FK_3925EA6E15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence_professeur ADD CONSTRAINT FK_3925EA6EBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E39D67D8AF FOREIGN KEY (maison_id) REFERENCES maison (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3FC56F556 FOREIGN KEY (notes_id) REFERENCES note (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687FFC56F556');
        $this->addSql('ALTER TABLE competence_professeur DROP FOREIGN KEY FK_3925EA6E15761DAB');
        $this->addSql('ALTER TABLE competence_professeur DROP FOREIGN KEY FK_3925EA6EBAB22EE9');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E39D67D8AF');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3FC56F556');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE competence_professeur');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE maison');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
