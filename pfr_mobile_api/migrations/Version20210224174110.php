<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224174110 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence ADD admin_agence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA93ED2363F FOREIGN KEY (admin_agence_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19AA93ED2363F ON agence (admin_agence_id)');
        $this->addSql('ALTER TABLE compte ADD agence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260D725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CFF65260D725330D ON compte (agence_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA93ED2363F');
        $this->addSql('DROP INDEX UNIQ_64C19AA93ED2363F ON agence');
        $this->addSql('ALTER TABLE agence DROP admin_agence_id');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260D725330D');
        $this->addSql('DROP INDEX UNIQ_CFF65260D725330D ON compte');
        $this->addSql('ALTER TABLE compte DROP agence_id');
    }
}
