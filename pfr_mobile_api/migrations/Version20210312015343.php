<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312015343 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F2C56620');
        $this->addSql('DROP INDEX IDX_723705D1F2C56620 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD compte_retrait_id INT DEFAULT NULL, DROP type, CHANGE compte_id compte_depot_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D17A04723 FOREIGN KEY (compte_depot_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1B6EC9AC4 FOREIGN KEY (compte_retrait_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_723705D17A04723 ON transaction (compte_depot_id)');
        $this->addSql('CREATE INDEX IDX_723705D1B6EC9AC4 ON transaction (compte_retrait_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D17A04723');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1B6EC9AC4');
        $this->addSql('DROP INDEX IDX_723705D17A04723 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1B6EC9AC4 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD compte_id INT DEFAULT NULL, ADD type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP compte_depot_id, DROP compte_retrait_id');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_723705D1F2C56620 ON transaction (compte_id)');
    }
}
