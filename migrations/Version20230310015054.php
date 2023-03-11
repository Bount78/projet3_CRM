<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310015054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146A76ED395');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('ALTER TABLE consent DROP FOREIGN KEY FK_6EA9A1469D86650F');
        $this->addSql('DROP INDEX IDX_631208109D86650F ON consent');
        $this->addSql('ALTER TABLE consent CHANGE user_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consent ADD CONSTRAINT FK_631208109D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_631208109D86650F ON consent (user_id_id)');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6389D86650F');
        $this->addSql('DROP INDEX IDX_4C62E6389D86650F ON contact');
        $this->addSql('ALTER TABLE contact CHANGE user_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6389D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4C62E6389D86650F ON contact (user_id_id)');
        $this->addSql('ALTER TABLE event CHANGE date_start date_start DATETIME NOT NULL, CHANGE date_end date_end DATETIME NOT NULL');
        $this->addSql('ALTER TABLE event RENAME INDEX idx_3bae0aa79d86650f TO IDX_3BAE0AA7A76ED395');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A23E5F2F7B');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A2526E8E58');
        $this->addSql('DROP INDEX IDX_F11D61A23E5F2F7B ON invitation');
        $this->addSql('DROP INDEX IDX_F11D61A2526E8E58 ON invitation');
        $this->addSql('ALTER TABLE invitation ADD event_id_id INT DEFAULT NULL, ADD contact_id_id INT DEFAULT NULL, DROP event_id, DROP contact_id');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A23E5F2F7B FOREIGN KEY (event_id_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2526E8E58 FOREIGN KEY (contact_id_id) REFERENCES contact (id)');
        $this->addSql('CREATE INDEX IDX_F11D61A23E5F2F7B ON invitation (event_id_id)');
        $this->addSql('CREATE INDEX IDX_F11D61A2526E8E58 ON invitation (contact_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6EA9A146A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6389D86650F');
        $this->addSql('DROP INDEX IDX_4C62E6389D86650F ON contact');
        $this->addSql('ALTER TABLE contact CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6389D86650F FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4C62E6389D86650F ON contact (user_id)');
        $this->addSql('ALTER TABLE consent DROP FOREIGN KEY FK_631208109D86650F');
        $this->addSql('DROP INDEX IDX_631208109D86650F ON consent');
        $this->addSql('ALTER TABLE consent CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consent ADD CONSTRAINT FK_6EA9A1469D86650F FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_631208109D86650F ON consent (user_id)');
        $this->addSql('ALTER TABLE event CHANGE date_start date_start DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE date_end date_end DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE event RENAME INDEX idx_3bae0aa7a76ed395 TO IDX_3BAE0AA79D86650F');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A23E5F2F7B');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A2526E8E58');
        $this->addSql('DROP INDEX IDX_F11D61A23E5F2F7B ON invitation');
        $this->addSql('DROP INDEX IDX_F11D61A2526E8E58 ON invitation');
        $this->addSql('ALTER TABLE invitation ADD event_id INT DEFAULT NULL, ADD contact_id INT DEFAULT NULL, DROP event_id_id, DROP contact_id_id');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A23E5F2F7B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2526E8E58 FOREIGN KEY (contact_id) REFERENCES contact (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F11D61A23E5F2F7B ON invitation (event_id)');
        $this->addSql('CREATE INDEX IDX_F11D61A2526E8E58 ON invitation (contact_id)');
    }
}
