<?php

namespace App\Repository;

use App\Entity\CardHasTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CardHasTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardHasTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardHasTag[]    findAll()
 * @method CardHasTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardHasTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardHasTag::class);
    }

    // /**
    //  * @return CardHasTag[] Returns an array of CardHasTag objects
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
    public function findOneBySomeField($value): ?CardHasTag
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
