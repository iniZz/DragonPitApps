<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210821191433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE applications_accepted (id INT AUTO_INCREMENT NOT NULL, discord_id VARCHAR(255) NOT NULL, steam_hex VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, que1 VARCHAR(255) NOT NULL, answ1 LONGTEXT NOT NULL, que2 VARCHAR(255) NOT NULL, answ2 LONGTEXT NOT NULL, que3 VARCHAR(255) NOT NULL, answ3 LONGTEXT NOT NULL, que4 VARCHAR(255) NOT NULL, answ4 LONGTEXT NOT NULL, que5 VARCHAR(255) NOT NULL, answ5 LONGTEXT NOT NULL, que6 VARCHAR(255) NOT NULL, answ6 LONGTEXT NOT NULL, status LONGTEXT NOT NULL, faster TINYINT(1) NOT NULL, reason LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE applications_rejected (id INT AUTO_INCREMENT NOT NULL, discord_id VARCHAR(255) NOT NULL, steam_hex VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, que1 VARCHAR(255) NOT NULL, answ1 LONGTEXT NOT NULL, que2 VARCHAR(255) NOT NULL, answ2 LONGTEXT NOT NULL, que3 VARCHAR(255) NOT NULL, answ3 LONGTEXT NOT NULL, que4 VARCHAR(255) NOT NULL, answ4 LONGTEXT NOT NULL, que5 VARCHAR(255) NOT NULL, answ5 LONGTEXT NOT NULL, que6 VARCHAR(255) NOT NULL, answ6 LONGTEXT NOT NULL, status LONGTEXT NOT NULL, faster TINYINT(1) NOT NULL, reason LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE applications_accepted');
        $this->addSql('DROP TABLE applications_rejected');
    }
}
