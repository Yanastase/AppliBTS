<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413093341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE alcools (id INT AUTO_INCREMENT NOT NULL, nom_alcool VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE boisson (id INT AUTO_INCREMENT NOT NULL, num_alcool_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, logo VARCHAR(80) NOT NULL, date_production DATE NOT NULL, INDEX IDX_8B97C84DE8E51F93 (num_alcool_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE boisson ADD CONSTRAINT FK_8B97C84DE8E51F93 FOREIGN KEY (num_alcool_id) REFERENCES alcools (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE boisson DROP FOREIGN KEY FK_8B97C84DE8E51F93
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE alcools
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE boisson
        SQL);
    }
}
