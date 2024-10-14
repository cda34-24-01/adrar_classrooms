<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cours>
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    function getAllCours()
    {
        return $this->createQueryBuilder('c')
            ->select('c.id', 'c.title', 'c.level', 'c.estimated_time', 'c.created_at', 'c.updated_at', 'c.files', 'c.validated', 'c.language_id')
            ->getQuery()
            ->getResult();
    }
    function getCours()
    {
        return $this->createQueryBuilder('c')
            ->select('c.id', 'c.title', 'c.level', 'c.estimated_time', 'c.created_at', 'c.updated_at', 'c.files', 'c.validated', 'c.language_id')
            ->where('c.title = $sTitle')
            ->getQuery()
            ->getResult();
    }

    function getCoursById(int $languagesId)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id', 'c.title', 'c.level', 'c.estimated_time', 'c.created_at', 'c.updated_at', 'c.files', 'c.validated', 'c.language_id')
            ->where('c.language_id = $languagesId')
            ->getQuery()
            ->getResult();
    }
}
