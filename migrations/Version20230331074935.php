<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331074935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factures DROP title, DROP content, DROP payment_intent, DROP slug');
        $this->addSql('ALTER TABLE paiements DROP FOREIGN KEY FK_E1B02E127F2DEE08');
        $this->addSql('DROP INDEX UNIQ_E1B02E127F2DEE08 ON paiements');
        $this->addSql('ALTER TABLE paiements DROP facture_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factures ADD title VARCHAR(255) NOT NULL, ADD content LONGTEXT NOT NULL, ADD payment_intent VARCHAR(255) DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE paiements ADD facture_id INT NOT NULL');
        $this->addSql('ALTER TABLE paiements ADD CONSTRAINT FK_E1B02E127F2DEE08 FOREIGN KEY (facture_id) REFERENCES factures (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E1B02E127F2DEE08 ON paiements (facture_id)');
    }
}
