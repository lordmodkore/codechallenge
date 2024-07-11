<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710143643 extends AbstractMigration
{
	public function getDescription(): string
	{
		return 'Create customers table';
	}

	public function up(Schema $schema): void
	{
		// Create customers table
		$this->addSql('CREATE TABLE customers (
            id INT AUTO_INCREMENT NOT NULL,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            username VARCHAR(255) NOT NULL,
            gender VARCHAR(255) NOT NULL,
            country VARCHAR(255) NOT NULL,
            city VARCHAR(255),
            phone VARCHAR(255) NOT NULL,
            password VARCHAR(32) NOT NULL,
            PRIMARY KEY(id),
            UNIQUE INDEX UNIQ_8D93D649E7927C74 (email),
            UNIQUE INDEX UNIQ_8D93D649F85E0677 (username)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
	}

	public function down(Schema $schema): void
	{
		// Drop customers table if migration is rolled back
		$this->addSql('DROP TABLE customers');
	}
}
