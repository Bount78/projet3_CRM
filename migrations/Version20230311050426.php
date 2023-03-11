<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230311050426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_contact DROP FOREIGN KEY FK_146FF832A76ED395');
        $this->addSql('ALTER TABLE user_contact DROP FOREIGN KEY FK_146FF832E7A1254A');
        $this->addSql('DROP TABLE user_contact');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_contact (user_id INT NOT NULL, contact_id INT NOT NULL, INDEX IDX_146FF832A76ED395 (user_id), INDEX IDX_146FF832E7A1254A (contact_id), PRIMARY KEY(user_id, contact_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_contact ADD CONSTRAINT FK_146FF832A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_contact ADD CONSTRAINT FK_146FF832E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
