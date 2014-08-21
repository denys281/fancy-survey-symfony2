<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140821111154 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE Answer ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Answer ADD CONSTRAINT FK_DD714F13A76ED395 FOREIGN KEY (user_id) REFERENCES User (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_DD714F13A76ED395 ON Answer (user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE Answer DROP FOREIGN KEY FK_DD714F13A76ED395');
        $this->addSql('DROP INDEX IDX_DD714F13A76ED395 ON Answer');
        $this->addSql('ALTER TABLE Answer DROP user_id');
    }
}
