<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515064150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_enfant (user_id INT NOT NULL, enfant_id INT NOT NULL, INDEX IDX_51E5179FA76ED395 (user_id), INDEX IDX_51E5179F450D2529 (enfant_id), PRIMARY KEY(user_id, enfant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_enfant ADD CONSTRAINT FK_51E5179FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_enfant ADD CONSTRAINT FK_51E5179F450D2529 FOREIGN KEY (enfant_id) REFERENCES enfant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_enfant DROP FOREIGN KEY FK_51E5179FA76ED395');
        $this->addSql('ALTER TABLE user_enfant DROP FOREIGN KEY FK_51E5179F450D2529');
        $this->addSql('DROP TABLE user_enfant');
    }
}
