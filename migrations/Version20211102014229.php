<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211102014229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe ADD courriel VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD id_employe INT NOT NULL, ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64926997AC9 FOREIGN KEY (id_employe) REFERENCES employe (id_employe)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64926997AC9 ON user (id_employe)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe DROP courriel');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64926997AC9');
        $this->addSql('DROP INDEX UNIQ_8D93D64926997AC9 ON user');
        $this->addSql('ALTER TABLE user DROP id_employe, DROP email');
    }
}
