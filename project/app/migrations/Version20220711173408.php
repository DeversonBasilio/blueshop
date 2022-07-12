<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220711173408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produto ADD foto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D77ABFA656 FOREIGN KEY (foto_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5CAC49D77ABFA656 ON produto (foto_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE produto DROP CONSTRAINT FK_5CAC49D77ABFA656');
        $this->addSql('DROP INDEX UNIQ_5CAC49D77ABFA656');
        $this->addSql('ALTER TABLE produto DROP foto_id');
    }
}
