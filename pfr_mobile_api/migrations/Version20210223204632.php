<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223204632 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence ADD is_deleted TINYINT(1) NOT NULL, ADD is_blocked TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE compte ADD is_deleted TINYINT(1) NOT NULL, ADD is_blocked TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD is_deleted TINYINT(1) NOT NULL, ADD is_blocked TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence DROP is_deleted, DROP is_blocked');
        $this->addSql('ALTER TABLE compte DROP is_deleted, DROP is_blocked');
        $this->addSql('ALTER TABLE user DROP is_deleted, DROP is_blocked');
    }
}