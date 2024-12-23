<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    public function findLastAdopted()
    {
        $now = new \DateTime('now');
        $lastMonth = new \Datetime('last day of last month');

        return $this->createQueryBuilder('a')
            ->andWhere('a.isAdopted =  :adopted')
            ->andWhere('a.dateAdoption <= :now')
            ->andWhere('a.dateAdoption >= :month')
            ->setParameter('adopted', true)
            ->setParameter('now', $now)
            ->setParameter('month', $lastMonth)
            ->getQuery()
            ->execute()
            ;
    }

    public function getRandomAnimals() {

        $rows = $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->andWhere('a.isAdopted =  :adopted')
            ->setParameter('adopted', false)
            ->getQuery()
            ->getSingleScalarResult();

        $offset = max(0, rand(0, $rows -1));

        $query = $this->createQueryBuilder('a')
            ->andWhere('a.isAdopted =  :adopted')
            ->setParameter('adopted', false)
            ->setMaxResults(3)
            ->setFirstResult($offset)
            ->getQuery();

        $result = $query->getResult();

        return $result;
    }

    // /**
    //  * @return Animal[] Returns an array of Animal objects
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
    public function findOneBySomeField($value): ?Animal
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
