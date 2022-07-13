<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211129083517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE habitat_service (habitat_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_BD84A570AFFE2D26 (habitat_id), INDEX IDX_BD84A570ED5CA9E6 (service_id), PRIMARY KEY(habitat_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitat_equipement (habitat_id INT NOT NULL, equipement_id INT NOT NULL, INDEX IDX_5EFDCD5DAFFE2D26 (habitat_id), INDEX IDX_5EFDCD5D806F0F5C (equipement_id), PRIMARY KEY(habitat_id, equipement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE habitat_service ADD CONSTRAINT FK_BD84A570AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habitat_service ADD CONSTRAINT FK_BD84A570ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habitat_equipement ADD CONSTRAINT FK_5EFDCD5DAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habitat_equipement ADD CONSTRAINT FK_5EFDCD5D806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE habitat_service');
        $this->addSql('DROP TABLE habitat_equipement');
    }
}
