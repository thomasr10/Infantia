<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526091227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE allergy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE child (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(100) NOT NULL, birth_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', entrance_date DATETIME NOT NULL, household_income INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE child_allergy (child_id INT NOT NULL, allergy_id INT NOT NULL, INDEX IDX_A9050AAEDD62C21B (child_id), INDEX IDX_A9050AAEDBFD579D (allergy_id), PRIMARY KEY(child_id, allergy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE child_representative (child_id INT NOT NULL, representative_id INT NOT NULL, INDEX IDX_D7BDE867DD62C21B (child_id), INDEX IDX_D7BDE867FC3FF006 (representative_id), PRIMARY KEY(child_id, representative_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE child_trusted_person (child_id INT NOT NULL, trusted_person_id INT NOT NULL, INDEX IDX_3C3739EADD62C21B (child_id), INDEX IDX_3C3739EA809CE65E (trusted_person_id), PRIMARY KEY(child_id, trusted_person_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE child_presence (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, child_id INT NOT NULL, entrance_hour TIME NOT NULL, exit_hour TIME NOT NULL, is_present TINYINT(1) NOT NULL, INDEX IDX_E370BA01B897366B (date_id), INDEX IDX_E370BA01DD62C21B (child_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE date (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, week_num INT NOT NULL, day VARCHAR(20) NOT NULL, is_holiday TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE educator (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, team_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8BA1BF3D9D86650F (user_id_id), INDEX IDX_8BA1BF3D296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE educator_presence (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, educator_id INT NOT NULL, entrance_hour TIME NOT NULL, exit_hour TIME NOT NULL, is_present TINYINT(1) DEFAULT NULL, INDEX IDX_2B45D8AB897366B (date_id), INDEX IDX_2B45D8A887E9271 (educator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE representative (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, adress VARCHAR(255) NOT NULL, postal_code INT NOT NULL, city VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_2507390E9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE scheduled_activity (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, team_id INT NOT NULL, activity_id INT NOT NULL, starting_hour TIME NOT NULL, ending_hour TIME NOT NULL, INDEX IDX_DDA14B85B897366B (date_id), INDEX IDX_DDA14B85296CD8AE (team_id), INDEX IDX_DDA14B8581C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE trusted_person (id INT AUTO_INCREMENT NOT NULL, adress VARCHAR(255) NOT NULL, postal_code INT NOT NULL, city VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(150) NOT NULL, phone_number VARCHAR(100) NOT NULL, birth_date DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', gender VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_allergy ADD CONSTRAINT FK_A9050AAEDD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_allergy ADD CONSTRAINT FK_A9050AAEDBFD579D FOREIGN KEY (allergy_id) REFERENCES allergy (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_representative ADD CONSTRAINT FK_D7BDE867DD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_representative ADD CONSTRAINT FK_D7BDE867FC3FF006 FOREIGN KEY (representative_id) REFERENCES representative (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_trusted_person ADD CONSTRAINT FK_3C3739EADD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_trusted_person ADD CONSTRAINT FK_3C3739EA809CE65E FOREIGN KEY (trusted_person_id) REFERENCES trusted_person (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_presence ADD CONSTRAINT FK_E370BA01B897366B FOREIGN KEY (date_id) REFERENCES date (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_presence ADD CONSTRAINT FK_E370BA01DD62C21B FOREIGN KEY (child_id) REFERENCES child (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE educator ADD CONSTRAINT FK_8BA1BF3D9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE educator ADD CONSTRAINT FK_8BA1BF3D296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE educator_presence ADD CONSTRAINT FK_2B45D8AB897366B FOREIGN KEY (date_id) REFERENCES date (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE educator_presence ADD CONSTRAINT FK_2B45D8A887E9271 FOREIGN KEY (educator_id) REFERENCES educator (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE representative ADD CONSTRAINT FK_2507390E9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scheduled_activity ADD CONSTRAINT FK_DDA14B85B897366B FOREIGN KEY (date_id) REFERENCES date (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scheduled_activity ADD CONSTRAINT FK_DDA14B85296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scheduled_activity ADD CONSTRAINT FK_DDA14B8581C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE child_allergy DROP FOREIGN KEY FK_A9050AAEDD62C21B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_allergy DROP FOREIGN KEY FK_A9050AAEDBFD579D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_representative DROP FOREIGN KEY FK_D7BDE867DD62C21B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_representative DROP FOREIGN KEY FK_D7BDE867FC3FF006
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_trusted_person DROP FOREIGN KEY FK_3C3739EADD62C21B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_trusted_person DROP FOREIGN KEY FK_3C3739EA809CE65E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_presence DROP FOREIGN KEY FK_E370BA01B897366B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_presence DROP FOREIGN KEY FK_E370BA01DD62C21B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE educator DROP FOREIGN KEY FK_8BA1BF3D9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE educator DROP FOREIGN KEY FK_8BA1BF3D296CD8AE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE educator_presence DROP FOREIGN KEY FK_2B45D8AB897366B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE educator_presence DROP FOREIGN KEY FK_2B45D8A887E9271
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE representative DROP FOREIGN KEY FK_2507390E9D86650F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scheduled_activity DROP FOREIGN KEY FK_DDA14B85B897366B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scheduled_activity DROP FOREIGN KEY FK_DDA14B85296CD8AE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scheduled_activity DROP FOREIGN KEY FK_DDA14B8581C06096
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE activity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE allergy
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE child
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE child_allergy
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE child_representative
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE child_trusted_person
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE child_presence
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE date
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE educator
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE educator_presence
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE representative
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE scheduled_activity
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE team
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE trusted_person
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
