<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181112135613 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE clever_task_history DROP FOREIGN KEY FK_F590F7D5B04EA75A');
        $this->addSql('DROP TABLE clever_process_history');
        $this->addSql('DROP TABLE clever_task_history');
        $this->addSql('ALTER TABLE eavmanager_family_permission CHANGE family_code family_code VARCHAR(255) NOT NULL');
        $this->addSql('CREATE INDEX family ON fabric_value (family_code)');
        $this->addSql('CREATE INDEX bool_search ON fabric_value (attribute_code, bool_value)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE clever_process_history (id INT AUTO_INCREMENT NOT NULL, process_code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, state VARCHAR(16) NOT NULL COLLATE utf8_unicode_ci, INDEX process_code (process_code), INDEX start_date (start_date), INDEX end_date (end_date), INDEX state (state), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clever_task_history (id INT AUTO_INCREMENT NOT NULL, process_history_id INT DEFAULT NULL, task_code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, logged_at DATETIME NOT NULL, level VARCHAR(16) NOT NULL COLLATE utf8_unicode_ci, context JSON DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\', reference VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, message LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_F590F7D5B04EA75A (process_history_id), INDEX task_code (task_code), INDEX logged_at (logged_at), INDEX level (level), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clever_task_history ADD CONSTRAINT FK_F590F7D5B04EA75A FOREIGN KEY (process_history_id) REFERENCES clever_process_history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eavmanager_family_permission CHANGE family_code family_code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:sidus_family)\'');
        $this->addSql('DROP INDEX family ON fabric_value');
        $this->addSql('DROP INDEX bool_search ON fabric_value');
    }
}
