<?php

namespace App\Repository;

use App\Entity\Medicaments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Medicaments>
 *
 * @method Medicaments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medicaments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medicaments[]    findAll()
 * @method Medicaments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicamentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medicaments::class);
    }

    //    /**
    //     * @return Medicaments[] Returns an array of Medicaments objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Medicaments
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
