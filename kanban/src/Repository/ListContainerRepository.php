<?php

namespace App\Repository;

use App\Entity\ListContainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListContainer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListContainer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListContainer[]    findAll()
 * @method ListContainer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListContainerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListContainer::class);
    }

    /**
     * @return ListContainer[] Returns an array of ListContainer objects
     */

    // public function findAll(): array
    // {
    //     return $this->createQueryBuilder(alias: 'p')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListContainer
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
