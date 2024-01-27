<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240127133817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokemon_attaque DROP FOREIGN KEY FK_F91F6703118FE712');
        $this->addSql('ALTER TABLE pokemon_attaque DROP FOREIGN KEY FK_F91F67032FE71C3E');
        $this->addSql('DROP TABLE pokemon_attaque');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pokemon_attaque (pokemon_id INT NOT NULL, attaque_id VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_F91F67032FE71C3E (pokemon_id), INDEX IDX_F91F6703118FE712 (attaque_id), PRIMARY KEY(pokemon_id, attaque_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pokemon_attaque ADD CONSTRAINT FK_F91F6703118FE712 FOREIGN KEY (attaque_id) REFERENCES attaque (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_attaque ADD CONSTRAINT FK_F91F67032FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
