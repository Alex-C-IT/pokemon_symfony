<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118092741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dresseur_pokemon (dresseur_id INT NOT NULL, pokemon_id INT NOT NULL, INDEX IDX_6F857270A1A01CBE (dresseur_id), INDEX IDX_6F8572702FE71C3E (pokemon_id), PRIMARY KEY(dresseur_id, pokemon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon_type (pokemon_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_B077296A2FE71C3E (pokemon_id), INDEX IDX_B077296AC54C8C93 (type_id), PRIMARY KEY(pokemon_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dresseur_pokemon ADD CONSTRAINT FK_6F857270A1A01CBE FOREIGN KEY (dresseur_id) REFERENCES dresseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dresseur_pokemon ADD CONSTRAINT FK_6F8572702FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_type ADD CONSTRAINT FK_B077296A2FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_type ADD CONSTRAINT FK_B077296AC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attaque ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attaque ADD CONSTRAINT FK_95751B92C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_95751B92C54C8C93 ON attaque (type_id)');
        $this->addSql('ALTER TABLE dresseur ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dresseur ADD CONSTRAINT FK_77EA2FC6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77EA2FC6A76ED395 ON dresseur (user_id)');
        $this->addSql('ALTER TABLE pokemon ADD generation_id INT DEFAULT NULL, ADD stats_id INT DEFAULT NULL, ADD consommables_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F3553A6EC4 FOREIGN KEY (generation_id) REFERENCES generation (id)');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F370AA3482 FOREIGN KEY (stats_id) REFERENCES stats (id)');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F37D07C020 FOREIGN KEY (consommables_id) REFERENCES consommable (id)');
        $this->addSql('CREATE INDEX IDX_62DC90F3553A6EC4 ON pokemon (generation_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62DC90F370AA3482 ON pokemon (stats_id)');
        $this->addSql('CREATE INDEX IDX_62DC90F37D07C020 ON pokemon (consommables_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dresseur_pokemon DROP FOREIGN KEY FK_6F857270A1A01CBE');
        $this->addSql('ALTER TABLE dresseur_pokemon DROP FOREIGN KEY FK_6F8572702FE71C3E');
        $this->addSql('ALTER TABLE pokemon_type DROP FOREIGN KEY FK_B077296A2FE71C3E');
        $this->addSql('ALTER TABLE pokemon_type DROP FOREIGN KEY FK_B077296AC54C8C93');
        $this->addSql('DROP TABLE dresseur_pokemon');
        $this->addSql('DROP TABLE pokemon_type');
        $this->addSql('ALTER TABLE attaque DROP FOREIGN KEY FK_95751B92C54C8C93');
        $this->addSql('DROP INDEX IDX_95751B92C54C8C93 ON attaque');
        $this->addSql('ALTER TABLE attaque DROP type_id');
        $this->addSql('ALTER TABLE dresseur DROP FOREIGN KEY FK_77EA2FC6A76ED395');
        $this->addSql('DROP INDEX UNIQ_77EA2FC6A76ED395 ON dresseur');
        $this->addSql('ALTER TABLE dresseur DROP user_id');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F3553A6EC4');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F370AA3482');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F37D07C020');
        $this->addSql('DROP INDEX IDX_62DC90F3553A6EC4 ON pokemon');
        $this->addSql('DROP INDEX UNIQ_62DC90F370AA3482 ON pokemon');
        $this->addSql('DROP INDEX IDX_62DC90F37D07C020 ON pokemon');
        $this->addSql('ALTER TABLE pokemon DROP generation_id, DROP stats_id, DROP consommables_id');
    }
}
