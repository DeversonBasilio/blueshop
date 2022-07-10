<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220710222017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE produto_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE produto (id INT NOT NULL, nome VARCHAR(255) NOT NULL, descricao VARCHAR(255) DEFAULT NULL, imagem BYTEA DEFAULT NULL, preco INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE produto_categoria (produto_id INT NOT NULL, categoria_id INT NOT NULL, PRIMARY KEY(produto_id, categoria_id))');
        $this->addSql('CREATE INDEX IDX_D5E7E35C105CFD56 ON produto_categoria (produto_id)');
        $this->addSql('CREATE INDEX IDX_D5E7E35C3397707A ON produto_categoria (categoria_id)');
        $this->addSql('ALTER TABLE produto_categoria ADD CONSTRAINT FK_D5E7E35C105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produto_categoria ADD CONSTRAINT FK_D5E7E35C3397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE produto_categoria DROP CONSTRAINT FK_D5E7E35C105CFD56');
        $this->addSql('DROP SEQUENCE produto_id_seq CASCADE');
        $this->addSql('DROP TABLE produto');
        $this->addSql('DROP TABLE produto_categoria');
    }
}
