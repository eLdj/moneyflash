<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190902093332 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D110335F61');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D15AF81F68');
        $this->addSql('DROP INDEX IDX_723705D110335F61 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D15AF81F68 ON transaction');
        $this->addSql('ALTER TABLE transaction DROP expediteur_id, DROP beneficiaire_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction ADD expediteur_id INT DEFAULT NULL, ADD beneficiaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D110335F61 FOREIGN KEY (expediteur_id) REFERENCES expediteur (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D15AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id)');
        $this->addSql('CREATE INDEX IDX_723705D110335F61 ON transaction (expediteur_id)');
        $this->addSql('CREATE INDEX IDX_723705D15AF81F68 ON transaction (beneficiaire_id)');
    }
}
