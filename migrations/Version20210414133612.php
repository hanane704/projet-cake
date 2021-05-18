<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210414133612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cake (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cake_category (cake_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_850446329F8008B6 (cake_id), INDEX IDX_8504463212469DE2 (category_id), PRIMARY KEY(cake_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, reference VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL, sent_at DATETIME NOT NULL, INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordered_quantity (id INT AUTO_INCREMENT NOT NULL, cake_id INT NOT NULL, from_order_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_15A365499F8008B6 (cake_id), INDEX IDX_15A36549CB708DA2 (from_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receipe (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_392996B7F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, fullname VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, postal_cd VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cake_category ADD CONSTRAINT FK_850446329F8008B6 FOREIGN KEY (cake_id) REFERENCES cake (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cake_category ADD CONSTRAINT FK_8504463212469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ordered_quantity ADD CONSTRAINT FK_15A365499F8008B6 FOREIGN KEY (cake_id) REFERENCES cake (id)');
        $this->addSql('ALTER TABLE ordered_quantity ADD CONSTRAINT FK_15A36549CB708DA2 FOREIGN KEY (from_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE receipe ADD CONSTRAINT FK_392996B7F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cake_category DROP FOREIGN KEY FK_850446329F8008B6');
        $this->addSql('ALTER TABLE ordered_quantity DROP FOREIGN KEY FK_15A365499F8008B6');
        $this->addSql('ALTER TABLE cake_category DROP FOREIGN KEY FK_8504463212469DE2');
        $this->addSql('ALTER TABLE ordered_quantity DROP FOREIGN KEY FK_15A36549CB708DA2');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE receipe DROP FOREIGN KEY FK_392996B7F675F31B');
        $this->addSql('DROP TABLE cake');
        $this->addSql('DROP TABLE cake_category');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE ordered_quantity');
        $this->addSql('DROP TABLE receipe');
        $this->addSql('DROP TABLE user');
    }
}
