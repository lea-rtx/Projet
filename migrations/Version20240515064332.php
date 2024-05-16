<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515064332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_femme (user_id INT NOT NULL, femme_id INT NOT NULL, INDEX IDX_93EE51D7A76ED395 (user_id), INDEX IDX_93EE51D7EA18A17C (femme_id), PRIMARY KEY(user_id, femme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_homme (user_id INT NOT NULL, homme_id INT NOT NULL, INDEX IDX_43630FD2A76ED395 (user_id), INDEX IDX_43630FD25BE2EC00 (homme_id), PRIMARY KEY(user_id, homme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_femme ADD CONSTRAINT FK_93EE51D7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_femme ADD CONSTRAINT FK_93EE51D7EA18A17C FOREIGN KEY (femme_id) REFERENCES femme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_homme ADD CONSTRAINT FK_43630FD2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_homme ADD CONSTRAINT FK_43630FD25BE2EC00 FOREIGN KEY (homme_id) REFERENCES homme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_femme DROP FOREIGN KEY FK_93EE51D7A76ED395');
        $this->addSql('ALTER TABLE user_femme DROP FOREIGN KEY FK_93EE51D7EA18A17C');
        $this->addSql('ALTER TABLE user_homme DROP FOREIGN KEY FK_43630FD2A76ED395');
        $this->addSql('ALTER TABLE user_homme DROP FOREIGN KEY FK_43630FD25BE2EC00');
        $this->addSql('DROP TABLE user_femme');
        $this->addSql('DROP TABLE user_homme');
    }
}
