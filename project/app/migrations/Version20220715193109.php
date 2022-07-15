<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220715193109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE categoria_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE image_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pedido_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pedido_itens_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE produto_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE usuario_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categoria (id INT NOT NULL, nome VARCHAR(127) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE image (id INT NOT NULL, filename VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pedido (id INT NOT NULL, usuario_id INT NOT NULL, datacriado TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(24) NOT NULL, total DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C4EC16CEDB38439E ON pedido (usuario_id)');
        $this->addSql('CREATE TABLE pedido_itens (id INT NOT NULL, produto_id INT NOT NULL, pedido_id INT NOT NULL, quantidade INT NOT NULL, total DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8E468BE8105CFD56 ON pedido_itens (produto_id)');
        $this->addSql('CREATE INDEX IDX_8E468BE84854653A ON pedido_itens (pedido_id)');
        $this->addSql('CREATE TABLE produto (id INT NOT NULL, foto_id INT DEFAULT NULL, nome VARCHAR(255) NOT NULL, descricao VARCHAR(255) DEFAULT NULL, preco DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5CAC49D77ABFA656 ON produto (foto_id)');
        $this->addSql('CREATE TABLE produto_categoria (produto_id INT NOT NULL, categoria_id INT NOT NULL, PRIMARY KEY(produto_id, categoria_id))');
        $this->addSql('CREATE INDEX IDX_D5E7E35C105CFD56 ON produto_categoria (produto_id)');
        $this->addSql('CREATE INDEX IDX_D5E7E35C3397707A ON produto_categoria (categoria_id)');
        $this->addSql('CREATE TABLE usuario (id INT NOT NULL, email VARCHAR(180) NOT NULL, nome VARCHAR(180) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, rua VARCHAR(255) DEFAULT NULL, bairro VARCHAR(128) DEFAULT NULL, cidade VARCHAR(128) DEFAULT NULL, cep VARCHAR(20) DEFAULT NULL, pais VARCHAR(64) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DE7927C74 ON usuario (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CEDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pedido_itens ADD CONSTRAINT FK_8E468BE8105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pedido_itens ADD CONSTRAINT FK_8E468BE84854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D77ABFA656 FOREIGN KEY (foto_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produto_categoria ADD CONSTRAINT FK_D5E7E35C105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produto_categoria ADD CONSTRAINT FK_D5E7E35C3397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE produto_categoria DROP CONSTRAINT FK_D5E7E35C3397707A');
        $this->addSql('ALTER TABLE produto DROP CONSTRAINT FK_5CAC49D77ABFA656');
        $this->addSql('ALTER TABLE pedido_itens DROP CONSTRAINT FK_8E468BE84854653A');
        $this->addSql('ALTER TABLE pedido_itens DROP CONSTRAINT FK_8E468BE8105CFD56');
        $this->addSql('ALTER TABLE produto_categoria DROP CONSTRAINT FK_D5E7E35C105CFD56');
        $this->addSql('ALTER TABLE pedido DROP CONSTRAINT FK_C4EC16CEDB38439E');
        $this->addSql('DROP SEQUENCE categoria_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE image_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pedido_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pedido_itens_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE produto_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE usuario_id_seq CASCADE');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('DROP TABLE pedido_itens');
        $this->addSql('DROP TABLE produto');
        $this->addSql('DROP TABLE produto_categoria');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
