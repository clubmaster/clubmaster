<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120215145238 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE club_user_location_config DROP FOREIGN KEY FK_3432EBBF64D218E");
        $this->addSql("ALTER TABLE club_user_location_config ADD CONSTRAINT FK_3432EBBF64D218E FOREIGN KEY (location_id) REFERENCES club_user_location(id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE club_user_location_config DROP FOREIGN KEY FK_3432EBBF64D218E");
        $this->addSql("ALTER TABLE club_user_location_config ADD CONSTRAINT FK_3432EBBF64D218E FOREIGN KEY (location_id) REFERENCES club_user_location(id)");
    }
}