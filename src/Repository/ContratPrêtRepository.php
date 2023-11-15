<?php

namespace App\Repository;

use App\Entity\ContratPrêt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContratPrêt>
 *
 * @method ContratPrêt|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContratPrêt|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContratPrêt[]    findAll()
 * @method ContratPrêt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratPrêtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratPrêt::class);
    }

//    /**
//     * @return ContratPrêt[] Returns an array of ContratPrêt objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ContratPrêt
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
