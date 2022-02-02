<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220202094805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag_note (tag_id INT NOT NULL, note_id INT NOT NULL, INDEX IDX_21B245A2BAD26311 (tag_id), INDEX IDX_21B245A226ED0855 (note_id), PRIMARY KEY(tag_id, note_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tag_note ADD CONSTRAINT FK_21B245A2BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_note ADD CONSTRAINT FK_21B245A226ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA149D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA149D86650F ON note (user_id_id)');
        $this->addSql('ALTER TABLE tag ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B7839D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_389B7839D86650F ON tag (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tag_note');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA149D86650F');
        $this->addSql('DROP INDEX IDX_CFBDFA149D86650F ON note');
        $this->addSql('ALTER TABLE note DROP user_id_id, CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE text text VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B7839D86650F');
        $this->addSql('DROP INDEX IDX_389B7839D86650F ON tag');
        $this->addSql('ALTER TABLE tag DROP user_id_id, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE fisrtname fisrtname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
