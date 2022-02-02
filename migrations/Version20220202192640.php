<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220202192640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, text VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_CFBDFA149D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_389B7839D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_note (tag_id INT NOT NULL, note_id INT NOT NULL, INDEX IDX_21B245A2BAD26311 (tag_id), INDEX IDX_21B245A226ED0855 (note_id), PRIMARY KEY(tag_id, note_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA149D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B7839D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tag_note ADD CONSTRAINT FK_21B245A2BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_note ADD CONSTRAINT FK_21B245A226ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tag_note DROP FOREIGN KEY FK_21B245A226ED0855');
        $this->addSql('ALTER TABLE tag_note DROP FOREIGN KEY FK_21B245A2BAD26311');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA149D86650F');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B7839D86650F');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_note');
        $this->addSql('DROP TABLE user');
    }
}
