<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211123191138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, trick_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_64C19C1B281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1B281BE2E FOREIGN KEY (trick_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E29C1004E');
        $this->addSql('DROP INDEX IDX_D8F0A91E29C1004E ON trick');
        $this->addSql('ALTER TABLE trick DROP video_id, DROP category');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1B281BE2E');
        $this->addSql('DROP TABLE category');
        $this->addSql('ALTER TABLE trick ADD video_id INT NOT NULL, ADD category VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E29C1004E FOREIGN KEY (video_id) REFERENCES trick (id)');
        $this->addSql('CREATE INDEX IDX_D8F0A91E29C1004E ON trick (video_id)');
    }
}
