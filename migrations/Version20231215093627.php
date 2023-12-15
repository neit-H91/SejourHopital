<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215093627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD le_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CE5CD64D FOREIGN KEY (le_service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649CE5CD64D ON user (le_service_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649CE5CD64D');
        $this->addSql('DROP INDEX IDX_8D93D649CE5CD64D ON `user`');
        $this->addSql('ALTER TABLE `user` DROP le_service_id');
    }
}
