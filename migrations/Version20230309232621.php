<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309232621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A1469D86650F');
        $this->addSql('DROP INDEX IDX_6EA9A1469D86650F ON calendar');
        $this->addSql('ALTER TABLE calendar CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6EA9A146A76ED395 ON calendar (user_id)');
        $this->addSql('ALTER TABLE consent DROP FOREIGN KEY FK_631208109D86650F');
        $this->addSql('DROP INDEX IDX_631208109D86650F ON consent');
        $this->addSql('ALTER TABLE consent CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE consent ADD CONSTRAINT FK_63120810A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_63120810A76ED395 ON consent (user_id)');
        $this->addSql('ALTER TABLE contact ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638A76ED395 ON contact (user_id)');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A76ED395');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146A76ED395');
        $this->addSql('DROP INDEX IDX_6EA9A146A76ED395 ON calendar');
        $this->addSql('ALTER TABLE calendar CHANGE user_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A1469D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6EA9A1469D86650F ON calendar (user_id_id)');
        $this->addSql('ALTER TABLE consent DROP FOREIGN KEY FK_63120810A76ED395');
        $this->addSql('DROP INDEX IDX_63120810A76ED395 ON consent');
        $this->addSql('ALTER TABLE consent CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE consent ADD CONSTRAINT FK_631208109D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_631208109D86650F ON consent (user_id_id)');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638A76ED395');
        $this->addSql('DROP INDEX IDX_4C62E638A76ED395 ON contact');
        $this->addSql('ALTER TABLE contact DROP user_id');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A76ED395');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
