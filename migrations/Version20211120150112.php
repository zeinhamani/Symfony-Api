<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211120150112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitat ADD user_id INT NOT NULL, ADD destination_id INT NOT NULL');
        $this->addSql('ALTER TABLE habitat ADD CONSTRAINT FK_3B37B2E8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE habitat ADD CONSTRAINT FK_3B37B2E8816C6140 FOREIGN KEY (destination_id) REFERENCES destination (id)');
        $this->addSql('CREATE INDEX IDX_3B37B2E8A76ED395 ON habitat (user_id)');
        $this->addSql('CREATE INDEX IDX_3B37B2E8816C6140 ON habitat (destination_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitat DROP FOREIGN KEY FK_3B37B2E8A76ED395');
        $this->addSql('ALTER TABLE habitat DROP FOREIGN KEY FK_3B37B2E8816C6140');
        $this->addSql('DROP INDEX IDX_3B37B2E8A76ED395 ON habitat');
        $this->addSql('DROP INDEX IDX_3B37B2E8816C6140 ON habitat');
        $this->addSql('ALTER TABLE habitat DROP user_id, DROP destination_id');
    }
}
