<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505151317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE websites (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_2527D78D7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE websites ADD CONSTRAINT FK_2527D78D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE post ADD bg_color1 VARCHAR(255) DEFAULT NULL, ADD bg_color2 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE websites DROP FOREIGN KEY FK_2527D78D7E3C61F9');
        $this->addSql('DROP TABLE websites');
        $this->addSql('ALTER TABLE post DROP bg_color1, DROP bg_color2');
    }
}
