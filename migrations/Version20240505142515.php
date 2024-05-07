<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505142515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE websites (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE websites_user (websites_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F7B2D3D3E4DFAB75 (websites_id), INDEX IDX_F7B2D3D3A76ED395 (user_id), PRIMARY KEY(websites_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE websites_user ADD CONSTRAINT FK_F7B2D3D3E4DFAB75 FOREIGN KEY (websites_id) REFERENCES websites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE websites_user ADD CONSTRAINT FK_F7B2D3D3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visitors CHANGE user_id user_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE websites_user DROP FOREIGN KEY FK_F7B2D3D3E4DFAB75');
        $this->addSql('ALTER TABLE websites_user DROP FOREIGN KEY FK_F7B2D3D3A76ED395');
        $this->addSql('DROP TABLE websites');
        $this->addSql('DROP TABLE websites_user');
        $this->addSql('ALTER TABLE visitors CHANGE user_id user_id INT DEFAULT NULL');
    }
}
