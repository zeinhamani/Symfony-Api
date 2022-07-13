<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118215339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE habitat (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, presentation LONGTEXT DEFAULT NULL, adresse VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, superficie INT NOT NULL, capacite_accueil INT NOT NULL, date_ouverture_du DATE NOT NULL, date_ouverture_au DATE NOT NULL, fermeture_exp VARCHAR(255) DEFAULT NULL, heure_arrivee_du TIME DEFAULT NULL, heure_arrivee_au TIME DEFAULT NULL, heure_depart_du TIME DEFAULT NULL, heure_depart_au TIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE habitat');
    }
}
