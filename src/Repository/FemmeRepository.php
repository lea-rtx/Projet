<?php

namespace App\Repository;

use App\Entity\Femme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Femme>
 *
 * @method Femme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Femme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Femme[]    findAll()
 * @method Femme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FemmeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Femme::class);
    }

    public function searchByTerm(string $term)
    {
        return $this->createQueryBuilder('e')
            ->where('e.nom LIKE :term OR e.description LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Femme[] Returns an array of Femme objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Femme
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
