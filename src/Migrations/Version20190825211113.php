<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190825211113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D113E878A');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1C2344C33');
        $this->addSql('DROP INDEX IDX_723705D113E878A ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1C2344C33 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD compte_id INT DEFAULT NULL, DROP compte_env_id, DROP compte_ret_id');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_723705D1F2C56620 ON transaction (compte_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F2C56620');
        $this->addSql('DROP INDEX IDX_723705D1F2C56620 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD compte_ret_id INT DEFAULT NULL, CHANGE compte_id compte_env_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D113E878A FOREIGN KEY (compte_ret_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1C2344C33 FOREIGN KEY (compte_env_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_723705D113E878A ON transaction (compte_ret_id)');
        $this->addSql('CREATE INDEX IDX_723705D1C2344C33 ON transaction (compte_env_id)');
    }
}
