<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200921184931 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE eventic_pointofsale DROP FOREIGN KEY FK_5D78D6FAA76ED395');
        $this->addSql('ALTER TABLE eventic_pointofsale ADD CONSTRAINT FK_5D78D6FAA76ED395 FOREIGN KEY (user_id) REFERENCES eventic_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eventic_scanner DROP FOREIGN KEY FK_241A84B0A76ED395');
        $this->addSql('ALTER TABLE eventic_scanner ADD CONSTRAINT FK_241A84B0A76ED395 FOREIGN KEY (user_id) REFERENCES eventic_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eventic_user DROP FOREIGN KEY FK_D01C6A2218E07BF3');
        $this->addSql('ALTER TABLE eventic_user DROP FOREIGN KEY FK_D01C6A2267C89E33');
        $this->addSql('ALTER TABLE eventic_user ADD CONSTRAINT FK_D01C6A2218E07BF3 FOREIGN KEY (pointofsale_id) REFERENCES eventic_pointofsale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eventic_user ADD CONSTRAINT FK_D01C6A2267C89E33 FOREIGN KEY (scanner_id) REFERENCES eventic_scanner (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE eventic_pointofsale DROP FOREIGN KEY FK_5D78D6FAA76ED395');
        $this->addSql('ALTER TABLE eventic_pointofsale ADD CONSTRAINT FK_5D78D6FAA76ED395 FOREIGN KEY (user_id) REFERENCES eventic_user (id)');
        $this->addSql('ALTER TABLE eventic_scanner DROP FOREIGN KEY FK_241A84B0A76ED395');
        $this->addSql('ALTER TABLE eventic_scanner ADD CONSTRAINT FK_241A84B0A76ED395 FOREIGN KEY (user_id) REFERENCES eventic_user (id)');
        $this->addSql('ALTER TABLE eventic_user DROP FOREIGN KEY FK_D01C6A2267C89E33');
        $this->addSql('ALTER TABLE eventic_user DROP FOREIGN KEY FK_D01C6A2218E07BF3');
        $this->addSql('ALTER TABLE eventic_user ADD CONSTRAINT FK_D01C6A2267C89E33 FOREIGN KEY (scanner_id) REFERENCES eventic_scanner (id)');
        $this->addSql('ALTER TABLE eventic_user ADD CONSTRAINT FK_D01C6A2218E07BF3 FOREIGN KEY (pointofsale_id) REFERENCES eventic_pointofsale (id)');
    }
}
