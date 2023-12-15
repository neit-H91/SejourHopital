<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215073908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chambre (id INT AUTO_INCREMENT NOT NULL, le_service_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_C509E4FFCE5CD64D (le_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lit (id INT AUTO_INCREMENT NOT NULL, la_chambre_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_5DDB8E9DBB113B80 (la_chambre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sejour (id INT AUTO_INCREMENT NOT NULL, le_lit_id INT NOT NULL, le_patient_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, est_arrive TINYINT(1) NOT NULL, est_parti TINYINT(1) NOT NULL, INDEX IDX_96F520288781A06B (le_lit_id), INDEX IDX_96F520284889EDD2 (le_patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FFCE5CD64D FOREIGN KEY (le_service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE lit ADD CONSTRAINT FK_5DDB8E9DBB113B80 FOREIGN KEY (la_chambre_id) REFERENCES chambre (id)');
        $this->addSql('ALTER TABLE sejour ADD CONSTRAINT FK_96F520288781A06B FOREIGN KEY (le_lit_id) REFERENCES lit (id)');
        $this->addSql('ALTER TABLE sejour ADD CONSTRAINT FK_96F520284889EDD2 FOREIGN KEY (le_patient_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FFCE5CD64D');
        $this->addSql('ALTER TABLE lit DROP FOREIGN KEY FK_5DDB8E9DBB113B80');
        $this->addSql('ALTER TABLE sejour DROP FOREIGN KEY FK_96F520288781A06B');
        $this->addSql('ALTER TABLE sejour DROP FOREIGN KEY FK_96F520284889EDD2');
        $this->addSql('DROP TABLE chambre');
        $this->addSql('DROP TABLE lit');
        $this->addSql('DROP TABLE sejour');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
