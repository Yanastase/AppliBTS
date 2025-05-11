<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425124221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE comptes DROP FOREIGN KEY FK_5673580113003845
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_5673580113003845 ON comptes
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comptes ADD username VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP num_role_id, DROP identifiant, DROP mot_de_passe, DROP num_tel
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE comptes ADD num_role_id INT DEFAULT NULL, ADD identifiant VARCHAR(255) NOT NULL, ADD mot_de_passe VARCHAR(255) NOT NULL, ADD num_tel VARCHAR(255) NOT NULL, DROP username, DROP password
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comptes ADD CONSTRAINT FK_5673580113003845 FOREIGN KEY (num_role_id) REFERENCES role (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5673580113003845 ON comptes (num_role_id)
        SQL);
    }
}
