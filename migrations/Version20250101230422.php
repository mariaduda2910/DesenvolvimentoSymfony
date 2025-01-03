<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250101230422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP nome, DROP senha, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_49CF2272BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer DROP nome, DROP senha, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_784FEC5FBF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD is_admin TINYINT(1) NOT NULL, ADD dtype VARCHAR(255) NOT NULL, CHANGE nome email VARCHAR(150) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Admin DROP FOREIGN KEY FK_49CF2272BF396750');
        $this->addSql('ALTER TABLE Admin ADD nome VARCHAR(255) NOT NULL, ADD senha VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE Customer DROP FOREIGN KEY FK_784FEC5FBF396750');
        $this->addSql('ALTER TABLE Customer ADD nome VARCHAR(255) NOT NULL, ADD senha VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP is_admin, DROP dtype, CHANGE email nome VARCHAR(150) NOT NULL');
    }
}
