<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506213153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feedbacks ADD CONSTRAINT FK_7E6C3F89A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_7E6C3F89A76ED395 ON feedbacks (user_id)');
        $this->addSql('ALTER TABLE `like` CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE post_id_id post_id_id INT DEFAULT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3E85F12B8 FOREIGN KEY (post_id_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B39D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_AC6340B3E85F12B8 ON `like` (post_id_id)');
        $this->addSql('CREATE INDEX IDX_AC6340B39D86650F ON `like` (user_id_id)');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY post_ibfk_1');
        $this->addSql('DROP INDEX author ON post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (author_id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT post_ibfk_1 FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('DROP INDEX Email ON user');
        $this->addSql('ALTER TABLE user CHANGE Role role VARCHAR(255) NOT NULL, CHANGE Verified verified SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE visitors DROP FOREIGN KEY visitors_ibfk_1');
        $this->addSql('DROP INDEX user_id ON visitors');
        $this->addSql('ALTER TABLE visitors CHANGE referrer referrer VARCHAR(255) DEFAULT NULL, CHANGE device device VARCHAR(255) NOT NULL, CHANGE browser browser VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feedbacks DROP FOREIGN KEY FK_7E6C3F89A76ED395');
        $this->addSql('DROP INDEX IDX_7E6C3F89A76ED395 ON feedbacks');
        $this->addSql('ALTER TABLE `like` MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3E85F12B8');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B39D86650F');
        $this->addSql('DROP INDEX IDX_AC6340B3E85F12B8 ON `like`');
        $this->addSql('DROP INDEX IDX_AC6340B39D86650F ON `like`');
        $this->addSql('DROP INDEX `primary` ON `like`');
        $this->addSql('ALTER TABLE `like` CHANGE id id INT NOT NULL, CHANGE post_id_id post_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF675F31B');
        $this->addSql('ALTER TABLE post CHANGE title title VARCHAR(30) NOT NULL, CHANGE description description TEXT NOT NULL, CHANGE image_format image_format VARCHAR(10) DEFAULT NULL, CHANGE date date DATE DEFAULT NULL, CHANGE bg_color1 bg_color1 VARCHAR(255) NOT NULL, CHANGE bg_color2 bg_color2 VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX idx_5a8a6c8df675f31b ON post');
        $this->addSql('CREATE INDEX Author ON post (author_id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` CHANGE role Role VARCHAR(255) DEFAULT \'User\', CHANGE verified Verified TINYINT(1) DEFAULT 0');
        $this->addSql('CREATE UNIQUE INDEX Email ON `user` (Email)');
        $this->addSql('ALTER TABLE visitors CHANGE referrer referrer VARCHAR(255) DEFAULT \'Direct\', CHANGE device device VARCHAR(255) DEFAULT \'Computer\', CHANGE browser browser VARCHAR(255) DEFAULT \'Other\'');
        $this->addSql('ALTER TABLE visitors ADD CONSTRAINT visitors_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX user_id ON visitors (user_id)');
    }
}
