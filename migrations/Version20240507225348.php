<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507225348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feedbacks (id INT AUTO_INCREMENT NOT NULL, userid_id INT DEFAULT NULL, date DATE DEFAULT NULL, feedback LONGTEXT NOT NULL, hidden SMALLINT DEFAULT NULL, INDEX IDX_7E6C3F8958E0A285 (userid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feedbacks ADD CONSTRAINT FK_7E6C3F8958E0A285 FOREIGN KEY (userid_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feedbacks DROP FOREIGN KEY FK_7E6C3F8958E0A285');
        $this->addSql('DROP TABLE feedbacks');
    }
}
