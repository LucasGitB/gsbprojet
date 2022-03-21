<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220321092313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiches DROP FOREIGN KEY FK_459C25C9D5E86FF');
        $this->addSql('DROP INDEX IDX_459C25C9D5E86FF ON fiches');
        $this->addSql('ALTER TABLE fiches ADD etat VARCHAR(255) NOT NULL, DROP etat_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiches ADD etat_id INT DEFAULT NULL, DROP etat');
        $this->addSql('ALTER TABLE fiches ADD CONSTRAINT FK_459C25C9D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_459C25C9D5E86FF ON fiches (etat_id)');
    }
}
