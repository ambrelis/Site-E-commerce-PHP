<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240312155412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_produits (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_de_produit VARCHAR(255) NOT NULL, utilisation VARCHAR(255) NOT NULL, nom_produit VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, produits_id INTEGER DEFAULT NULL, content CLOB NOT NULL, CONSTRAINT FK_9474526CCD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9474526CCD11A2CF ON comment (produits_id)');
        $this->addSql('CREATE TABLE mots_cles (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, mot VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE produits (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE produits_categorie_produits (produits_id INTEGER NOT NULL, categorie_produits_id INTEGER NOT NULL, PRIMARY KEY(produits_id, categorie_produits_id), CONSTRAINT FK_21F4B0DACD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_21F4B0DA12EF84C6 FOREIGN KEY (categorie_produits_id) REFERENCES categorie_produits (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_21F4B0DACD11A2CF ON produits_categorie_produits (produits_id)');
        $this->addSql('CREATE INDEX IDX_21F4B0DA12EF84C6 ON produits_categorie_produits (categorie_produits_id)');
        $this->addSql('CREATE TABLE produits_mots_cles (produits_id INTEGER NOT NULL, mots_cles_id INTEGER NOT NULL, PRIMARY KEY(produits_id, mots_cles_id), CONSTRAINT FK_BCC643CACD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BCC643CAC0BE80DB FOREIGN KEY (mots_cles_id) REFERENCES mots_cles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BCC643CACD11A2CF ON produits_mots_cles (produits_id)');
        $this->addSql('CREATE INDEX IDX_BCC643CAC0BE80DB ON produits_mots_cles (mots_cles_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categorie_produits');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE mots_cles');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE produits_categorie_produits');
        $this->addSql('DROP TABLE produits_mots_cles');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
