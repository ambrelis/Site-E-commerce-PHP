<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409120143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__elements_panier AS SELECT id, id_element, id_panier, id_produit, quantite, prix FROM elements_panier');
        $this->addSql('DROP TABLE elements_panier');
        $this->addSql('CREATE TABLE elements_panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, enregistrement_id INTEGER DEFAULT NULL, id_element INTEGER NOT NULL, id_panier INTEGER NOT NULL, id_produit INTEGER NOT NULL, quantite INTEGER NOT NULL, prix NUMERIC(10, 0) NOT NULL, CONSTRAINT FK_84CDDD3C833460 FOREIGN KEY (enregistrement_id) REFERENCES panier (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO elements_panier (id, id_element, id_panier, id_produit, quantite, prix) SELECT id, id_element, id_panier, id_produit, quantite, prix FROM __temp__elements_panier');
        $this->addSql('DROP TABLE __temp__elements_panier');
        $this->addSql('CREATE INDEX IDX_84CDDD3C833460 ON elements_panier (enregistrement_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__panier AS SELECT id, id_utilisateur, date_creation_panier, statut_panier FROM panier');
        $this->addSql('DROP TABLE panier');
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, elements_panier_id INTEGER DEFAULT NULL, id_utilisateur INTEGER DEFAULT NULL, date_creation_panier DATETIME DEFAULT NULL, statut_panier CLOB NOT NULL, CONSTRAINT FK_24CC0DF29A73DC1F FOREIGN KEY (elements_panier_id) REFERENCES elements_panier (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO panier (id, id_utilisateur, date_creation_panier, statut_panier) SELECT id, id_utilisateur, date_creation_panier, statut_panier FROM __temp__panier');
        $this->addSql('DROP TABLE __temp__panier');
        $this->addSql('CREATE INDEX IDX_24CC0DF29A73DC1F ON panier (elements_panier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__elements_panier AS SELECT id, id_element, id_panier, id_produit, quantite, prix FROM elements_panier');
        $this->addSql('DROP TABLE elements_panier');
        $this->addSql('CREATE TABLE elements_panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_element INTEGER NOT NULL, id_panier INTEGER NOT NULL, id_produit INTEGER NOT NULL, quantite INTEGER NOT NULL, prix NUMERIC(10, 0) NOT NULL)');
        $this->addSql('INSERT INTO elements_panier (id, id_element, id_panier, id_produit, quantite, prix) SELECT id, id_element, id_panier, id_produit, quantite, prix FROM __temp__elements_panier');
        $this->addSql('DROP TABLE __temp__elements_panier');
        $this->addSql('CREATE TEMPORARY TABLE __temp__panier AS SELECT id, id_utilisateur, date_creation_panier, statut_panier FROM panier');
        $this->addSql('DROP TABLE panier');
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_utilisateur INTEGER DEFAULT NULL, date_creation_panier DATETIME DEFAULT NULL, statut_panier CLOB NOT NULL)');
        $this->addSql('INSERT INTO panier (id, id_utilisateur, date_creation_panier, statut_panier) SELECT id, id_utilisateur, date_creation_panier, statut_panier FROM __temp__panier');
        $this->addSql('DROP TABLE __temp__panier');
    }
}
