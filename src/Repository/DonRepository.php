<?php
  
  namespace App\Repository;
  
  use App\Entity\Don;
  use App\Entity\User;
  use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
  use Doctrine\ORM\NonUniqueResultException;
  use Doctrine\ORM\NoResultException;
  use Doctrine\Persistence\ManagerRegistry;
  
  /**
   * @method Don|null find($id, $lockMode = null, $lockVersion = null)
   * @method Don|null findOneBy(array $criteria, array $orderBy = null)
   * @method Don[]    findAll()
   * @method Don[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
   */
  class DonRepository extends ServiceEntityRepository
  {
    public function __construct(ManagerRegistry $registry)
    {
      parent::__construct($registry, Don::class);
    }
    
    
    public function fetchLastDon(): Don
    {
      return $this->findOneBy([], ['date_transaction' => 'ASC']);
    }
    
    public function fecthDonById(int $idDon): Don
    {
      return $this->find($idDon);
    }
    
    public function fetchDonList(): array
    {
      //todo: pagination
      return $this->createQueryBuilder('d')
          ->orderBy('d.date_transaction', 'DESC')
          ->getQuery()
          ->getResult();
    }
    
    public function fecthUserDonList(int $idUser): \stdClass
    {
      $userDons = new \stdClass();
      $userDons->list = $this->createQueryBuilder('d')
          ->orderBy('d.date_transaction', 'DESC')
          ->where('d.user = :idUser')
          ->setParameter('idUser', $idUser)
          ->getQuery()
          ->getResult();
      $userDons->listTotal = count($userDons->list);
      $userDons->listSum = array_sum(array_map(function ($don) {
        return $don->getMontant();
      }, $userDons->list));
      return $userDons;
    }
    
    
    
    // /**
    //  * @return Don[] Returns an array of Don objects
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
    public function findOneBySomeField($value): ?Don
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
