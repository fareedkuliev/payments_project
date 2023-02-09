<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230130103859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accounts (id INT AUTO_INCREMENT NOT NULL, user_email VARCHAR(55) NOT NULL, account_number VARCHAR(55) NOT NULL, balance DOUBLE PRECISION NOT NULL, currency VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cards (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, card_number VARCHAR(16) NOT NULL, payment_system VARCHAR(20) NOT NULL, expiration_date DATE NOT NULL, pin_code VARCHAR(4) NOT NULL, cvc VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(55) NOT NULL, password VARCHAR(255) NOT NULL, phone_number VARCHAR(20) NOT NULL, role TINYINT(1) DEFAULT NULL, first_name VARCHAR(55) NOT NULL, last_name VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utility_services (id INT AUTO_INCREMENT NOT NULL, service_тфname VARCHAR(55) NOT NULL, account_number VARCHAR(55) NOT NULL, balance DOUBLE PRECISION NOT NULL, currency VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE accounts');
        $this->addSql('DROP TABLE cards');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE utility_services');
    }
}
