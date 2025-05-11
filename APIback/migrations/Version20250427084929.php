<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250427084929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE csv_a_completer__1_
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE boisson CHANGE logo logo VARCHAR(80) NOT NULL, CHANGE date_production date_production DATE NOT NULL, CHANGE prix prix NUMERIC(10, 0) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier ADD num_produit_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF280233E70 FOREIGN KEY (num_produit_id) REFERENCES boisson (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_24CC0DF280233E70 ON panier (num_produit_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE csv_a_completer__1_ (COL 1 INT DEFAULT NULL, COL 2 INT DEFAULT NULL, COL 3 VARCHAR(26) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, COL 4 VARCHAR(10) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, COL 5 VARCHAR(10) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, COL 6 INT DEFAULT NULL) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = MyISAM COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE boisson CHANGE logo logo VARCHAR(80) DEFAULT NULL, CHANGE date_production date_production VARCHAR(50) DEFAULT NULL, CHANGE prix prix INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF280233E70
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_24CC0DF280233E70 ON panier
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier DROP num_produit_id
        SQL);
    }
}
