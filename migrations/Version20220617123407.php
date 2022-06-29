<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220617123407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente CHANGE imagen imagen LONGBLOB NOT NULL');
        $this->addSql('ALTER TABLE contato CHANGE telefone telefone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE depoimento CHANGE imagen imagen LONGBLOB NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente CHANGE imagen imagen LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\'');
        $this->addSql('ALTER TABLE contato CHANGE telefone telefone INT NOT NULL');
        $this->addSql('ALTER TABLE depoimento CHANGE imagen imagen LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\'');
    }
}
