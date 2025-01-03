<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250103150544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP is_checked');
        $this->addSql('ALTER TABLE customer ADD is_checked TINYINT(1) NOT NULL, DROP nome');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD is_checked TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE customer ADD nome VARCHAR(255) NOT NULL, DROP is_checked');
    }
}
