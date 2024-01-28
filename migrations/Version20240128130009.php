<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240128130009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dresseur_pokemon (dresseur_id INT NOT NULL, pokemon_id INT NOT NULL, INDEX IDX_6F857270A1A01CBE (dresseur_id), INDEX IDX_6F8572702FE71C3E (pokemon_id), PRIMARY KEY(dresseur_id, pokemon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dresseur_pokemon ADD CONSTRAINT FK_6F857270A1A01CBE FOREIGN KEY (dresseur_id) REFERENCES dresseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dresseur_pokemon ADD CONSTRAINT FK_6F8572702FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dresseur_dresseur DROP FOREIGN KEY FK_356A4BE6B02C2F9');
        $this->addSql('ALTER TABLE dresseur_dresseur DROP FOREIGN KEY FK_356A4BE72E79276');
        $this->addSql('DROP TABLE dresseur_dresseur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dresseur_dresseur (dresseur_source INT NOT NULL, dresseur_target INT NOT NULL, INDEX IDX_356A4BE6B02C2F9 (dresseur_source), INDEX IDX_356A4BE72E79276 (dresseur_target), PRIMARY KEY(dresseur_source, dresseur_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE dresseur_dresseur ADD CONSTRAINT FK_356A4BE6B02C2F9 FOREIGN KEY (dresseur_source) REFERENCES dresseur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dresseur_dresseur ADD CONSTRAINT FK_356A4BE72E79276 FOREIGN KEY (dresseur_target) REFERENCES dresseur (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dresseur_pokemon DROP FOREIGN KEY FK_6F857270A1A01CBE');
        $this->addSql('ALTER TABLE dresseur_pokemon DROP FOREIGN KEY FK_6F8572702FE71C3E');
        $this->addSql('DROP TABLE dresseur_pokemon');
    }
}
