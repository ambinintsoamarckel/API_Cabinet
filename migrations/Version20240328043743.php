<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328043743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, date DATETIME NOT NULL, motif LONGTEXT NOT NULL, diagnostic VARCHAR(255) NOT NULL, total_paye INT NOT NULL, UNIQUE INDEX UNIQ_964685A6AA9E377A (date), INDEX IDX_964685A66B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicaments (id INT AUTO_INCREMENT NOT NULL, consultation_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, posologie VARCHAR(10) NOT NULL, duree VARCHAR(255) NOT NULL, note VARCHAR(255) DEFAULT NULL, INDEX IDX_DD988ACB62FF6CDF (consultation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_de_naissance DATE NOT NULL, telephone VARCHAR(10) NOT NULL, sexe TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1ADAD7EB450FF010 (telephone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, debut DATETIME NOT NULL, fin DATETIME NOT NULL, limite INT NOT NULL, UNIQUE INDEX UNIQ_D499BFF6E81B0679 (debut), UNIQUE INDEX UNIQ_D499BFF6AD2EF231 (fin), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendezvous (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, planning_id INT NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_C09A9BA86B899279 (patient_id), INDEX IDX_C09A9BA83D865311 (planning_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, telephone VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_8D93D649450FF010 (telephone), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE medicaments ADD CONSTRAINT FK_DD988ACB62FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id)');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA86B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA83D865311 FOREIGN KEY (planning_id) REFERENCES planning (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A66B899279');
        $this->addSql('ALTER TABLE medicaments DROP FOREIGN KEY FK_DD988ACB62FF6CDF');
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA86B899279');
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA83D865311');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE medicaments');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE rendezvous');
        $this->addSql('DROP TABLE user');
    }
}
