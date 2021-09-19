<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210919114927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card (id INT AUTO_INCREMENT NOT NULL, list_id INT NOT NULL, content VARCHAR(255) NOT NULL, position INT NOT NULL, color VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_161498D3BDE922D0 (list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card_tag (card_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_537933424ACC9A20 (card_id), INDEX IDX_53793342BAD26311 (tag_id), PRIMARY KEY(card_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_container (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3BDE922D0 FOREIGN KEY (list_id) REFERENCES list_container (id)');
        $this->addSql('ALTER TABLE card_tag ADD CONSTRAINT FK_537933424ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card_tag ADD CONSTRAINT FK_53793342BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_tag DROP FOREIGN KEY FK_537933424ACC9A20');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3BDE922D0');
        $this->addSql('ALTER TABLE card_tag DROP FOREIGN KEY FK_53793342BAD26311');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE card_tag');
        $this->addSql('DROP TABLE list_container');
        $this->addSql('DROP TABLE tag');
    }
}
