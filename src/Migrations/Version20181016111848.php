<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181016111848 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE etweet (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, content VARCHAR(255) NOT NULL, dating DATETIME NOT NULL, INDEX IDX_12BFC26C296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rt (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, etweet_id INT NOT NULL, INDEX IDX_BB8BCAE296CD8AE (team_id), INDEX IDX_BB8BCAE859EECB7 (etweet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', avatar_file_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, e_tweet_id INT NOT NULL, vote_value INT NOT NULL, INDEX IDX_5A108564296CD8AE (team_id), INDEX IDX_5A108564CCC1517 (e_tweet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etweet ADD CONSTRAINT FK_12BFC26C296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE rt ADD CONSTRAINT FK_BB8BCAE296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE rt ADD CONSTRAINT FK_BB8BCAE859EECB7 FOREIGN KEY (etweet_id) REFERENCES etweet (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564CCC1517 FOREIGN KEY (e_tweet_id) REFERENCES etweet (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rt DROP FOREIGN KEY FK_BB8BCAE859EECB7');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564CCC1517');
        $this->addSql('ALTER TABLE etweet DROP FOREIGN KEY FK_12BFC26C296CD8AE');
        $this->addSql('ALTER TABLE rt DROP FOREIGN KEY FK_BB8BCAE296CD8AE');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564296CD8AE');
        $this->addSql('DROP TABLE etweet');
        $this->addSql('DROP TABLE rt');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE vote');
    }
}
