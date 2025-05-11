<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413141333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE comptes (id INT AUTO_INCREMENT NOT NULL, num_role_id INT DEFAULT NULL, identifiant VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, num_tel VARCHAR(255) NOT NULL, INDEX IDX_5673580113003845 (num_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, num_compte_id INT DEFAULT NULL, quantitép INT NOT NULL, creation_panier DATE NOT NULL, INDEX IDX_24CC0DF2801B12FC (num_compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stocks (id INT AUTO_INCREMENT NOT NULL, num_boisson_id INT DEFAULT NULL, quantité INT NOT NULL, prix NUMERIC(10, 0) NOT NULL, INDEX IDX_56F79805FC5CC002 (num_boisson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comptes ADD CONSTRAINT FK_5673580113003845 FOREIGN KEY (num_role_id) REFERENCES role (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2801B12FC FOREIGN KEY (num_compte_id) REFERENCES comptes (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stocks ADD CONSTRAINT FK_56F79805FC5CC002 FOREIGN KEY (num_boisson_id) REFERENCES boisson (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE comptes DROP FOREIGN KEY FK_5673580113003845
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2801B12FC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE stocks DROP FOREIGN KEY FK_56F79805FC5CC002
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE comptes
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE panier
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE role
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stocks
        SQL);
    }
}
