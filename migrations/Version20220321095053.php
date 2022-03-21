<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220321095053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE fiche_hors_forfait DROP FOREIGN KEY FK_5B7AF371D5E86FF');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP INDEX IDX_5B7AF371D5E86FF ON fiche_hors_forfait');
        $this->addSql('ALTER TABLE fiche_hors_forfait ADD etat TINYINT(1) NOT NULL, DROP etat_id');
        $this->addSql('ALTER TABLE fiches CHANGE etat etat TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE fiche_hors_forfait ADD etat_id INT DEFAULT NULL, DROP etat');
        $this->addSql('ALTER TABLE fiche_hors_forfait ADD CONSTRAINT FK_5B7AF371D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_5B7AF371D5E86FF ON fiche_hors_forfait (etat_id)');
        $this->addSql('ALTER TABLE fiches CHANGE etat etat VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
