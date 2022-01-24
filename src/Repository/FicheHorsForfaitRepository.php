<?php

namespace App\Repository;

use App\Entity\FicheHorsForfait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FicheHorsForfait|null find($id, $lockMode = null, $lockVersion = null)
 * @method FicheHorsForfait|null findOneBy(array $criteria, array $orderBy = null)
 * @method FicheHorsForfait[]    findAll()
 * @method FicheHorsForfait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheHorsForfaitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FicheHorsForfait::class);
    }

    // /**
    //  * @return FicheHorsForfait[] Returns an array of FicheHorsForfait objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FicheHorsForfait
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
