<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190816094901 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, code_genere INT NOT NULL, montant_transfert INT NOT NULL, frais_transaction INT NOT NULL, total_envoi INT NOT NULL, commission_etat INT NOT NULL, commission_systeme INT NOT NULL, commission_retrait INT NOT NULL, commission_envoie INT NOT NULL, statut VARCHAR(255) DEFAULT NULL, date_retrait DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur CHANGE image image VARCHAR(255) , CHANGE updated_at updated_at DATETIME');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE transaction');
        $this->addSql('ALTER TABLE utilisateur CHANGE image image VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }
}
