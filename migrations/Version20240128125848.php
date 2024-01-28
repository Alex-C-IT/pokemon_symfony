<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240128125848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attaque (id VARCHAR(10) NOT NULL, type_id VARCHAR(10) DEFAULT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, puissance INT NOT NULL, prec INT NOT NULL, pp INT NOT NULL, cs TINYINT(1) NOT NULL, INDEX IDX_95751B92C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consommable (id VARCHAR(10) NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dresseur (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(25) NOT NULL, taille INT NOT NULL, sexe TINYINT(1) NOT NULL, message VARCHAR(120) DEFAULT NULL, UNIQUE INDEX UNIQ_77EA2FC66C6E55B5 (nom), UNIQUE INDEX UNIQ_77EA2FC6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dresseur_dresseur (dresseur_source INT NOT NULL, dresseur_target INT NOT NULL, INDEX IDX_356A4BE6B02C2F9 (dresseur_source), INDEX IDX_356A4BE72E79276 (dresseur_target), PRIMARY KEY(dresseur_source, dresseur_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE generation (id VARCHAR(10) NOT NULL, numero VARCHAR(2) NOT NULL, annee VARCHAR(4) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon (id INT AUTO_INCREMENT NOT NULL, generation_id VARCHAR(10) DEFAULT NULL, stats_id INT DEFAULT NULL, consommable_id VARCHAR(10) DEFAULT NULL, numero VARCHAR(4) NOT NULL, nom VARCHAR(30) NOT NULL, image VARCHAR(50) NOT NULL, mini_image VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_62DC90F3F55AE19E (numero), UNIQUE INDEX UNIQ_62DC90F36C6E55B5 (nom), INDEX IDX_62DC90F3553A6EC4 (generation_id), UNIQUE INDEX UNIQ_62DC90F370AA3482 (stats_id), INDEX IDX_62DC90F3C9CEB381 (consommable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon_type (pokemon_id INT NOT NULL, type_id VARCHAR(10) NOT NULL, INDEX IDX_B077296A2FE71C3E (pokemon_id), INDEX IDX_B077296AC54C8C93 (type_id), PRIMARY KEY(pokemon_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon_attaque (pokemon_id INT NOT NULL, attaque_id VARCHAR(10) NOT NULL, INDEX IDX_F91F67032FE71C3E (pokemon_id), INDEX IDX_F91F6703118FE712 (attaque_id), PRIMARY KEY(pokemon_id, attaque_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stats (id INT AUTO_INCREMENT NOT NULL, pv INT NOT NULL, attaque INT NOT NULL, defense INT NOT NULL, vitesse INT NOT NULL, special INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id VARCHAR(10) NOT NULL, libelle VARCHAR(25) NOT NULL, image VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom_utilisateur VARCHAR(25) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_inscription DATETIME NOT NULL, status INT NOT NULL, mail_envoye TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attaque ADD CONSTRAINT FK_95751B92C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE dresseur ADD CONSTRAINT FK_77EA2FC6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE dresseur_dresseur ADD CONSTRAINT FK_356A4BE6B02C2F9 FOREIGN KEY (dresseur_source) REFERENCES dresseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dresseur_dresseur ADD CONSTRAINT FK_356A4BE72E79276 FOREIGN KEY (dresseur_target) REFERENCES dresseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F3553A6EC4 FOREIGN KEY (generation_id) REFERENCES generation (id)');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F370AA3482 FOREIGN KEY (stats_id) REFERENCES stats (id)');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F3C9CEB381 FOREIGN KEY (consommable_id) REFERENCES consommable (id)');
        $this->addSql('ALTER TABLE pokemon_type ADD CONSTRAINT FK_B077296A2FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_type ADD CONSTRAINT FK_B077296AC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_attaque ADD CONSTRAINT FK_F91F67032FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_attaque ADD CONSTRAINT FK_F91F6703118FE712 FOREIGN KEY (attaque_id) REFERENCES attaque (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attaque DROP FOREIGN KEY FK_95751B92C54C8C93');
        $this->addSql('ALTER TABLE dresseur DROP FOREIGN KEY FK_77EA2FC6A76ED395');
        $this->addSql('ALTER TABLE dresseur_dresseur DROP FOREIGN KEY FK_356A4BE6B02C2F9');
        $this->addSql('ALTER TABLE dresseur_dresseur DROP FOREIGN KEY FK_356A4BE72E79276');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F3553A6EC4');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F370AA3482');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F3C9CEB381');
        $this->addSql('ALTER TABLE pokemon_type DROP FOREIGN KEY FK_B077296A2FE71C3E');
        $this->addSql('ALTER TABLE pokemon_type DROP FOREIGN KEY FK_B077296AC54C8C93');
        $this->addSql('ALTER TABLE pokemon_attaque DROP FOREIGN KEY FK_F91F67032FE71C3E');
        $this->addSql('ALTER TABLE pokemon_attaque DROP FOREIGN KEY FK_F91F6703118FE712');
        $this->addSql('DROP TABLE attaque');
        $this->addSql('DROP TABLE consommable');
        $this->addSql('DROP TABLE dresseur');
        $this->addSql('DROP TABLE dresseur_dresseur');
        $this->addSql('DROP TABLE generation');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE pokemon_type');
        $this->addSql('DROP TABLE pokemon_attaque');
        $this->addSql('DROP TABLE stats');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
