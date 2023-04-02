<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328070814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messages_tickets (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, messages_id INT NOT NULL, auteur_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATE NOT NULL, INDEX IDX_4DEDC92F727ACA70 (parent_id), INDEX IDX_4DEDC92FA5905F5A (messages_id), INDEX IDX_4DEDC92F60BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tickets (id INT AUTO_INCREMENT NOT NULL, auteur_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_54469DF460BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE messages_tickets ADD CONSTRAINT FK_4DEDC92F727ACA70 FOREIGN KEY (parent_id) REFERENCES messages_tickets (id)');
        $this->addSql('ALTER TABLE messages_tickets ADD CONSTRAINT FK_4DEDC92FA5905F5A FOREIGN KEY (messages_id) REFERENCES tickets (id)');
        $this->addSql('ALTER TABLE messages_tickets ADD CONSTRAINT FK_4DEDC92F60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF460BB6FE6 FOREIGN KEY (auteur_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages_tickets DROP FOREIGN KEY FK_4DEDC92F727ACA70');
        $this->addSql('ALTER TABLE messages_tickets DROP FOREIGN KEY FK_4DEDC92FA5905F5A');
        $this->addSql('ALTER TABLE messages_tickets DROP FOREIGN KEY FK_4DEDC92F60BB6FE6');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF460BB6FE6');
        $this->addSql('DROP TABLE messages_tickets');
        $this->addSql('DROP TABLE tickets');
    }
}
