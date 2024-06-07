<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240607073227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE customer_loans_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE loan_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE customer_loans (id INT NOT NULL, customer_id BIGINT NOT NULL, loan_id BIGINT NOT NULL, due_date TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE loan (id INT NOT NULL, name VARCHAR(255) NOT NULL, term_days INT NOT NULL, percent INT NOT NULL, amount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE customer ADD state VARCHAR(255) NOT NULL DEFAULT \'\'');
        $this->addSql('ALTER TABLE customer ADD zip VARCHAR(255) NOT NULL DEFAULT \'\'');
        $this->addSql('ALTER TABLE customer RENAME COLUMN address TO city');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE customer_loans_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE loan_id_seq CASCADE');
        $this->addSql('DROP TABLE customer_loans');
        $this->addSql('DROP TABLE loan');
        $this->addSql('ALTER TABLE customer ADD address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE customer DROP city');
        $this->addSql('ALTER TABLE customer DROP state');
        $this->addSql('ALTER TABLE customer DROP zip');
    }
}
