<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211102010519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe CHANGE courriel courriel VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B944FB41C9 FOREIGN KEY (courriel) REFERENCES user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F804D3B944FB41C9 ON employe (courriel)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B944FB41C9');
        $this->addSql('DROP INDEX UNIQ_F804D3B944FB41C9 ON employe');
        $this->addSql('ALTER TABLE employe CHANGE courriel courriel VARCHAR(20) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
    }
}
