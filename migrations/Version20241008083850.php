<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241008083850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE citation_stagiaire ADD auteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE citation_stagiaire ADD CONSTRAINT FK_4B22F4CC60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4B22F4CC60BB6FE6 ON citation_stagiaire (auteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE citation_stagiaire DROP FOREIGN KEY FK_4B22F4CC60BB6FE6');
        $this->addSql('DROP INDEX UNIQ_4B22F4CC60BB6FE6 ON citation_stagiaire');
        $this->addSql('ALTER TABLE citation_stagiaire DROP auteur_id');
    }
}
