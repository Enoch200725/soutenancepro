<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260628181901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE soutenance (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, etudiant_id INT NOT NULL, president_id INT NOT NULL, rapporteur_id INT NOT NULL, examinateur_id INT NOT NULL, salle_id INT NOT NULL, UNIQUE INDEX UNIQ_4D59FF6EDDEAB1A3 (etudiant_id), INDEX IDX_4D59FF6EB40A33C7 (president_id), INDEX IDX_4D59FF6E2AF5D182 (rapporteur_id), INDEX IDX_4D59FF6E9D8D68C0 (examinateur_id), INDEX IDX_4D59FF6EDC304035 (salle_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE soutenance ADD CONSTRAINT FK_4D59FF6EDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE soutenance ADD CONSTRAINT FK_4D59FF6EB40A33C7 FOREIGN KEY (president_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE soutenance ADD CONSTRAINT FK_4D59FF6E2AF5D182 FOREIGN KEY (rapporteur_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE soutenance ADD CONSTRAINT FK_4D59FF6E9D8D68C0 FOREIGN KEY (examinateur_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE soutenance ADD CONSTRAINT FK_4D59FF6EDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE soutenance DROP FOREIGN KEY FK_4D59FF6EDDEAB1A3');
        $this->addSql('ALTER TABLE soutenance DROP FOREIGN KEY FK_4D59FF6EB40A33C7');
        $this->addSql('ALTER TABLE soutenance DROP FOREIGN KEY FK_4D59FF6E2AF5D182');
        $this->addSql('ALTER TABLE soutenance DROP FOREIGN KEY FK_4D59FF6E9D8D68C0');
        $this->addSql('ALTER TABLE soutenance DROP FOREIGN KEY FK_4D59FF6EDC304035');
        $this->addSql('DROP TABLE soutenance');
    }
}
