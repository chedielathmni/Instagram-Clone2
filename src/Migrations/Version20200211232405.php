<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211232405 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491816E3A3');
        $this->addSql('DROP INDEX IDX_8D93D6491816E3A3 ON user');
        $this->addSql('ALTER TABLE user ADD followed_id INT DEFAULT NULL, CHANGE following_id follower_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AC24F853 FOREIGN KEY (follower_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D956F010 FOREIGN KEY (followed_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649AC24F853 ON user (follower_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D956F010 ON user (followed_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AC24F853');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D956F010');
        $this->addSql('DROP INDEX IDX_8D93D649AC24F853 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649D956F010 ON user');
        $this->addSql('ALTER TABLE user ADD following_id INT DEFAULT NULL, DROP follower_id, DROP followed_id');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491816E3A3 FOREIGN KEY (following_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6491816E3A3 ON user (following_id)');
    }
}
