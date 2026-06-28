<?php

namespace App\Repository;

use App\Entity\Enseignant;
use App\Entity\Soutenance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Soutenance>
 */
class SoutenanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Soutenance::class);
    }

    /**
     * @return Soutenance[] Retourne toutes les soutenances où l'enseignant
     * est président, rapporteur OU examinateur.
     */
    public function findByEnseignant(Enseignant $enseignant): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.president = :enseignant OR s.rapporteur = :enseignant OR s.examinateur = :enseignant')
            ->setParameter('enseignant', $enseignant)
            ->orderBy('s.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}