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
    
    
    public function fetchLastDon(): Don|null
    {
      return $this->findOneBy([], ['date_transaction' => 'ASC']);
    }
    
    public function fecthDonById(int $idDon): Don
    {
      return $this->find($idDon);
    }
    
    public function fetchDonList(): \stdClass|null
    {
      //todo: pagination
      $listDons = $this->createQueryBuilder('d')
          ->orderBy('d.date_transaction', 'DESC')
          ->getQuery()
          ->getResult();
      return $this->setStdListClass($listDons);
    }
    
    public function fecthUserDonList(int $idUser): \stdClass
    {
      $userDons = $this->createQueryBuilder('d')
          ->orderBy('d.date_transaction', 'DESC')
          ->where('d.user = :idUser')
          ->setParameter('idUser', $idUser)
          ->getQuery()
          ->getResult();
      return $this->setStdListClass($userDons);
    }
    
    
    private function setStdListClass(array $_list): \stdClass
    {
      $list = new \stdClass();
      $list->list = !empty($_list) || $_list != null ? $_list : [];
      $list->total = count($_list);
      $list->sum = array_sum(array_map(function ($don) {
        return $don->getMontant();
      }, $_list));
      return $list;
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
