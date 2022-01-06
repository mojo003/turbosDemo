<?php

namespace App\Repository;

use App\Entity\CompteEmploye;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompteEmploye|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteEmploye|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteEmploye[]    findAll()
 * @method CompteEmploye[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteEmployeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteEmploye::class);
    }

    // /**
    //  * @return CompteEmploye[] Returns an array of CompteEmploye objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompteEmploye
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
