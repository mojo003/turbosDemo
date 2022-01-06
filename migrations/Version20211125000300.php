<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125000300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image CHANGE img img VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE service CHANGE type_de_service type_de_service VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE `demande_de_service` CHANGE `adresse` `adresse` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL');
        $this->addSql('ALTER TABLE `demande_de_service` CHANGE `courriel` `courriel` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL');   
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image CHANGE img img BLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE service CHANGE type_de_service type_de_service VARCHAR(20) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
 
    }
}
