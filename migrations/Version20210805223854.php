<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210805223854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE applications ADD que3 VARCHAR(255) NOT NULL, ADD answ3 LONGTEXT NOT NULL, ADD que4 VARCHAR(255) NOT NULL, ADD answ4 LONGTEXT NOT NULL, ADD que5 VARCHAR(255) NOT NULL, ADD answ5 LONGTEXT NOT NULL, ADD que6 VARCHAR(255) NOT NULL, ADD answ6 LONGTEXT NOT NULL, CHANGE discord_id discord_id VARCHAR(255) NOT NULL, CHANGE birth_date birth_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE questions ADD que3 VARCHAR(255) NOT NULL, ADD que4 VARCHAR(255) NOT NULL, ADD que5 VARCHAR(255) NOT NULL, ADD que6 VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE applications DROP que3, DROP answ3, DROP que4, DROP answ4, DROP que5, DROP answ5, DROP que6, DROP answ6, CHANGE discord_id discord_id VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\' NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE birth_date birth_date DATE DEFAULT \'0000-00-00\' NOT NULL');
        $this->addSql('ALTER TABLE questions DROP que3, DROP que4, DROP que5, DROP que6');
    }
}
