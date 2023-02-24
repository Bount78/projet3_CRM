<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224154143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6EA9A1469D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consent (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, finalite VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, accept TINYINT(1) NOT NULL, date_consenti DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_631208109D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, type_contact VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4C62E638E7927C74 (email), INDEX IDX_4C62E6389D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, calendar_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, date_start DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_end DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3BAE0AA79D86650F (user_id_id), INDEX IDX_3BAE0AA713109D39 (calendar_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invitation (id INT AUTO_INCREMENT NOT NULL, event_id_id INT DEFAULT NULL, contact_id_id INT DEFAULT NULL, INDEX IDX_F11D61A23E5F2F7B (event_id_id), INDEX IDX_F11D61A2526E8E58 (contact_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rolepermission (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rolepermission_user (rolepermission_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_69AD235030D402BF (rolepermission_id), INDEX IDX_69AD2350A76ED395 (user_id), PRIMARY KEY(rolepermission_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rolepermission_permission (rolepermission_id INT NOT NULL, permission_id INT NOT NULL, INDEX IDX_FA5BE93A30D402BF (rolepermission_id), INDEX IDX_FA5BE93AFED90CCA (permission_id), PRIMARY KEY(rolepermission_id, permission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(200) DEFAULT NULL, last_name VARCHAR(200) NOT NULL, profile_image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A1469D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consent ADD CONSTRAINT FK_631208109D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6389D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA79D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA713109D39 FOREIGN KEY (calendar_id_id) REFERENCES calendar (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A23E5F2F7B FOREIGN KEY (event_id_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2526E8E58 FOREIGN KEY (contact_id_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE rolepermission_user ADD CONSTRAINT FK_69AD235030D402BF FOREIGN KEY (rolepermission_id) REFERENCES rolepermission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rolepermission_user ADD CONSTRAINT FK_69AD2350A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rolepermission_permission ADD CONSTRAINT FK_FA5BE93A30D402BF FOREIGN KEY (rolepermission_id) REFERENCES rolepermission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rolepermission_permission ADD CONSTRAINT FK_FA5BE93AFED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A1469D86650F');
        $this->addSql('ALTER TABLE consent DROP FOREIGN KEY FK_631208109D86650F');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6389D86650F');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA79D86650F');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA713109D39');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A23E5F2F7B');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A2526E8E58');
        $this->addSql('ALTER TABLE rolepermission_user DROP FOREIGN KEY FK_69AD235030D402BF');
        $this->addSql('ALTER TABLE rolepermission_user DROP FOREIGN KEY FK_69AD2350A76ED395');
        $this->addSql('ALTER TABLE rolepermission_permission DROP FOREIGN KEY FK_FA5BE93A30D402BF');
        $this->addSql('ALTER TABLE rolepermission_permission DROP FOREIGN KEY FK_FA5BE93AFED90CCA');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE consent');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE rolepermission');
        $this->addSql('DROP TABLE rolepermission_user');
        $this->addSql('DROP TABLE rolepermission_permission');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
