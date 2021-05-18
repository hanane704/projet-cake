<?php

namespace App\Repository;

use App\Entity\Receipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Receipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Receipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Receipe[]    findAll()
 * @method Receipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReceipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Receipe::class);
    }

    // /**
    //  * @return Receipe[] Returns an array of Receipe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Receipe
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
