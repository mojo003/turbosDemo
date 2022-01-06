<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211026011858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE TABLE commentaire (id_commentaire INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) DEFAULT NULL, description VARCHAR(200) DEFAULT NULL, statut INT DEFAULT NULL, PRIMARY KEY(id_commentaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        /*$this->addSql('CREATE TABLE compte_employe (id INT AUTO_INCREMENT NOT NULL, id_employe INT DEFAULT NULL, nom VARCHAR(20) DEFAULT NULL, mot_de_passe TEXT DEFAULT NULL, INDEX id_employe (id_employe), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_de_service (id_demande_service INT AUTO_INCREMENT NOT NULL, id_service INT DEFAULT NULL, nom VARCHAR(20) DEFAULT NULL, prenom VARCHAR(20) DEFAULT NULL, adresse VARCHAR(50) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, courriel VARCHAR(50) DEFAULT NULL, description VARCHAR(200) DEFAULT NULL, date_heure DATETIME DEFAULT NULL, statut TINYINT(1) NOT NULL, INDEX id_service (id_service), PRIMARY KEY(id_demande_service)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id_employe INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) DEFAULT NULL, prenom VARCHAR(20) DEFAULT NULL, adresse VARCHAR(20) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, courriel VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id_employe)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe_service (id INT AUTO_INCREMENT NOT NULL, id_employe INT DEFAULT NULL, id_service INT DEFAULT NULL, INDEX id_service (id_service), INDEX id_employe (id_employe), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id_image INT AUTO_INCREMENT NOT NULL, caption VARCHAR(20) DEFAULT NULL, description VARCHAR(200) DEFAULT NULL, img BLOB DEFAULT NULL, PRIMARY KEY(id_image)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id_service INT AUTO_INCREMENT NOT NULL, type_de_service VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id_service)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compte_employe ADD CONSTRAINT FK_4063EFEF26997AC9 FOREIGN KEY (id_employe) REFERENCES employe (id_employe)');
        $this->addSql('ALTER TABLE demande_de_service ADD CONSTRAINT FK_2B49A6F03F0033A2 FOREIGN KEY (id_service) REFERENCES service (id_service)');
        $this->addSql('ALTER TABLE employe_service ADD CONSTRAINT FK_2592F67126997AC9 FOREIGN KEY (id_employe) REFERENCES employe (id_employe)');
        $this->addSql('ALTER TABLE employe_service ADD CONSTRAINT FK_2592F6713F0033A2 FOREIGN KEY (id_service) REFERENCES service (id_service)'); */
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_employe DROP FOREIGN KEY FK_4063EFEF26997AC9');
        $this->addSql('ALTER TABLE employe_service DROP FOREIGN KEY FK_2592F67126997AC9');
        $this->addSql('ALTER TABLE demande_de_service DROP FOREIGN KEY FK_2B49A6F03F0033A2');
        $this->addSql('ALTER TABLE employe_service DROP FOREIGN KEY FK_2592F6713F0033A2');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE compte_employe');
        $this->addSql('DROP TABLE demande_de_service');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE employe_service');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE user');
    }
}
