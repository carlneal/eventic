<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200524185046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eventic_app_layout_setting (id INT AUTO_INCREMENT NOT NULL, logo_name VARCHAR(50) DEFAULT NULL, logo_size INT DEFAULT NULL, logo_mime_type VARCHAR(50) DEFAULT NULL, logo_original_name VARCHAR(1000) DEFAULT NULL, logo_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', favicon_name VARCHAR(50) DEFAULT NULL, favicon_size INT DEFAULT NULL, favicon_mime_type VARCHAR(50) DEFAULT NULL, favicon_original_name VARCHAR(1000) DEFAULT NULL, favicon_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE eventic_app_layout_setting');
    }
}
