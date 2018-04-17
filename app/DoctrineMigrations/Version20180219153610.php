<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180219153610 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE s_show ADD user_id INT DEFAULT NULL, DROP author');
        $this->addSql('ALTER TABLE s_show ADD CONSTRAINT FK_957D80CBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_957D80CBA76ED395 ON s_show (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE s_show DROP FOREIGN KEY FK_957D80CBA76ED395');
        $this->addSql('DROP INDEX IDX_957D80CBA76ED395 ON s_show');
        $this->addSql('ALTER TABLE s_show ADD author VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP user_id');
    }
}
