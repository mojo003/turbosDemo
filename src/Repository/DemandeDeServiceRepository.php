<?php

namespace App\Repository;

use App\Entity\DemandeDeService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method DemandeDeService|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeDeService|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeDeService[]    findAll()
 * @method DemandeDeService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method DemandeDeService[]    returnOlderThanWeek()
 */
class DemandeDeServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeDeService::class);
    }

    /**
     * returns all services older than one week
     */
    public function returnOlderThanWeek() {
        $query = $this->getEntityManager()->createQuery("
        SELECT ('d.*') FROM App\Entity\DemandeDeService d WHERE d.dateHeure < DATE_SUB(CURRENT_TIMESTAMP(), 1, 'week')
        ");
        return $query->getResult(Query::HYDRATE_OBJECT);
    }

    public function returnOlderThan($jours) {
        $qb = $this->createQueryBuilder('d')
        ->andWhere("d.dateHeure < DATE_SUB(CURRENT_TIMESTAMP(), :nb, 'day')")
        ->setParameter('nb', $jours)
        ->orderBy('d.dateHeure', 'DESC')
    ;
    return $qb->getQuery()->getResult();
    } 


    /**
    * @return DemandeDeService[] Returns a Service
    */
    
    public function searchDemandeService($textToSearch)
    {
        $demande = "%" . trim($textToSearch) . "%";
        return $this->createQueryBuilder('d')
            ->where('d.nom LIKE :texte')
            //->where('s.typeDeService LIKE \'%Net%\'')
            ->orderBy('d.nom', 'ASC')
            // ->setMaxResults(10)
            ->setParameter('texte', $demande)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return DemandeDeService[] Returns an array of DemandeDeService objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DemandeDeService
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
