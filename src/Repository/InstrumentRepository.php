<?php

namespace App\Repository;

use App\Entity\Instrument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Instrument>
 *
 * @method Instrument|null find($id, $lockMode = null, $lockVersion = null)
 * @method Instrument|null findOneBy(array $criteria, array $orderBy = null)
 * @method Instrument[]    findAll()
 * @method Instrument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstrumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Instrument::class);
    }
    public function findBySearchTerm(string $searchTerm)
    {
        return $this->createQueryBuilder('i')
            ->leftJoin('i.marque', 'm')
            ->leftJoin('i.TypeInstrument', 't')
            ->leftJoin('t.ClasseInstrument', 'c')
            ->where('i.numSerie LIKE :searchTerm')
            ->orWhere('m.libelle LIKE :searchTerm')
            ->orWhere('t.libelle LIKE :searchTerm')
            ->orWhere('c.libelle LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->getQuery()
            ->getResult();
    }

    public function findAllSorted(string $sortField, string $sortOrder): array
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.' . $sortField, $sortOrder)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Instrument[] Returns an array of Instrument objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Instrument
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
