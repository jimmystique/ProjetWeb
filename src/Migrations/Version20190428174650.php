<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190428174650 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE qualities');
        $this->addSql('ALTER TABLE user ADD quality1 VARCHAR(255) DEFAULT NULL, ADD quality2 VARCHAR(255) DEFAULT NULL, ADD quality3 VARCHAR(255) DEFAULT NULL, ADD quality4 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE qualities (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, quality1 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, quality2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, quality3 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, quality4 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user DROP quality1, DROP quality2, DROP quality3, DROP quality4');
    }
}
