<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620011952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente CHANGE imagen imagen VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE depoimento CHANGE imagen imagen VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE noticia CHANGE imagen imagen VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente CHANGE imagen imagen LONGBLOB NOT NULL');
        $this->addSql('ALTER TABLE depoimento CHANGE imagen imagen LONGBLOB NOT NULL');
        $this->addSql('ALTER TABLE noticia CHANGE imagen imagen LONGBLOB NOT NULL');
    }
}
