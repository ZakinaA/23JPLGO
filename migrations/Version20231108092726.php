<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231108092726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(20) NOT NULL, libelle VARCHAR(50) NOT NULL, nb_etudiants_max VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence_professeur (competence_id INT NOT NULL, professeur_id INT NOT NULL, INDEX IDX_3925EA6E15761DAB (competence_id), INDEX IDX_3925EA6EBAB22EE9 (professeur_id), PRIMARY KEY(competence_id, professeur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, date_naiss DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence_professeur ADD CONSTRAINT FK_3925EA6E15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence_professeur ADD CONSTRAINT FK_3925EA6EBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence_professeur DROP FOREIGN KEY FK_3925EA6E15761DAB');
        $this->addSql('ALTER TABLE competence_professeur DROP FOREIGN KEY FK_3925EA6EBAB22EE9');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE competence_professeur');
        $this->addSql('DROP TABLE professeur');
    }
}
