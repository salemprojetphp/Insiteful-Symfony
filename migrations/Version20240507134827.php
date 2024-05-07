<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507134827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feedbacks (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, date DATE DEFAULT NULL, feedback LONGTEXT NOT NULL, hidden SMALLINT DEFAULT NULL, INDEX IDX_7E6C3F899D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feedbacks ADD CONSTRAINT FK_7E6C3F899D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON user');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE websites (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_2527D78D7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE websites ADD CONSTRAINT FK_2527D78D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE feedbacks DROP FOREIGN KEY FK_7E6C3F899D86650F');
        $this->addSql('DROP TABLE feedbacks');
        $this->addSql('ALTER TABLE post CHANGE bg_color1 bg_color1 VARCHAR(255) NOT NULL, CHANGE bg_color2 bg_color2 VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `user` ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP role');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON `user` (Email)');
    }
}
