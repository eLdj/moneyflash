<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190902094231 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateur ADD profil VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD nom_complet_e VARCHAR(255) NOT NULL, ADD tel_e VARCHAR(255) NOT NULL, ADD adresse_e VARCHAR(255) DEFAULT NULL, ADD cin_e VARCHAR(255) NOT NULL, ADD nom_complet_b VARCHAR(255) NOT NULL, ADD tel_b VARCHAR(255) NOT NULL, ADD adresse_b VARCHAR(255) DEFAULT NULL, ADD cin_b VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP nom_complet_e, DROP tel_e, DROP adresse_e, DROP cin_e, DROP nom_complet_b, DROP tel_b, DROP adresse_b, DROP cin_b');
        $this->addSql('ALTER TABLE utilisateur DROP profil');
    }
}
