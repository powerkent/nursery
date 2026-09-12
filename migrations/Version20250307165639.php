<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250307165639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change family_id field in customer table to nullable same with trusted_person table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer CHANGE family_id family_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trusted_person CHANGE family_id family_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer CHANGE family_id family_id INT NOT NULL');
        $this->addSql('ALTER TABLE trusted_person CHANGE family_id family_id INT NOT NULL');
    }

    public function isTransactional(): bool
    {
        return false;
    }
}
