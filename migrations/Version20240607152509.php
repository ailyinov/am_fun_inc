<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240607152509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer ADD monthly_income INT NOT NULL');
        $this->addSql('ALTER TABLE customer ALTER state DROP DEFAULT');
        $this->addSql('ALTER TABLE customer ALTER zip DROP DEFAULT');
        $this->addSql('ALTER TABLE customer_loans ADD percent INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE customer_loans DROP percent');
        $this->addSql('ALTER TABLE customer DROP monthly_income');
        $this->addSql('ALTER TABLE customer ALTER state SET DEFAULT \'\'');
        $this->addSql('ALTER TABLE customer ALTER zip SET DEFAULT \'\'');
    }
}
