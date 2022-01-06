<?php

namespace App\Repository;

use App\Entity\ArchiveService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArchiveService|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArchiveService|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArchiveService[]    findAll()
 * @method ArchiveService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchiveServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArchiveService::class);
    }

    /**
    * @return ArchiveService[] Returns les archives
    */
    
    public function searchArchiveEmploye($archiveToSearch)
    {
        $archive = "%" . trim($archiveToSearch) . "%";
        return $this->createQueryBuilder('a')
            ->where('a.nom LIKE :texte')
            ->orderBy('a.nom', 'ASC')
            ->setParameter('texte', $archive)
            ->getQuery()
            ->getResult()
        ;
    }


    
    // /**
    //  * @return ArchiveService[] Returns an array of ArchiveService objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */



    /*
    public function findOneBySomeField($value): ?ArchiveService
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
