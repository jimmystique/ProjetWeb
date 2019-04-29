<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\UserFind;
use Doctrine\ORM\Query;
use App\Entity\UserSearch;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }



    public function findAllUsers() {
         return $this->createQueryBuilder('u')
            ->getQuery()
            ->getResult();
    }



    public function findAllUsersWithLevel() {
         return $this->createQueryBuilder('u')
            ->andWhere("u.level != 'rien'")
            ->getQuery()
            ->getResult();
    }

      public function findAllUsersWithLevelSearch(UserSearch $search): Query {
        if($search->getLevel() != 'rien'){
            if($search->getSubject()==NULL){

                    dump($search);
                    $query = $this->createQueryBuilder('u');
                    $query->orWhere("u.level = 'L3'")
                           ->andWhere("u.subject != 'rien'");
                     if($search->getLevel() == 'L3'){
                         $query->andWhere("u.subject != 'rien'");
                         return $query->getQuery();
                    }

                    $query->orWhere("u.level = 'L2'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == 'L2'){

                          return $query->getQuery();
                    }

                    $query->orWhere("u.level = 'L1'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == 'L1'){
                          return $query->getQuery();
                    }

                    $query->orWhere("u.level = 'Terminale'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == 'Terminale'){
                          return $query->getQuery();
                    }


                     $query->orWhere("u.level = '1re'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == '1re'){
                          return $query->getQuery();
                    }

                    $query->orWhere("u.level = '2nde'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == '2nde'){
                          return $query->getQuery();
                    }


                    $query->orWhere("u.level = '3eme'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == '3eme'){
                          return $query->getQuery();
                    }

                    $query->orWhere("u.level = '4eme'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == '4eme'){
                         $query->andWhere("u.subject != 'rien'");
                          return $query->getQuery();
                    }


                    $query->orWhere("u.level = '5eme'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == '5eme'){
                          return $query->getQuery();
                    }

                    $query->orWhere("u.level = '6eme'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == '6eme'){
                          return $query->getQuery();
                    }

                    return $query->getQuery();
            }


                    dump($search);
                    $query = $this->createQueryBuilder('u');
                    $query->orWhere("u.level = 'L3'")
                           ->andWhere("u.subject != 'rien'");
                     if($search->getLevel() == 'L3'){
                         $query->andWhere("u.subject = '".$search->getSubject()."'");
                         return $query->getQuery();
                    }

                    $query->orWhere("u.level = 'L2'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == 'L2'){
                          $query->andWhere("u.subject = '".$search->getSubject()."'");
                          return $query->getQuery();
                    }

                    $query->orWhere("u.level = 'L1'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == 'L1'){
                          $query->andWhere("u.subject = '".$search->getSubject()."'");
                          return $query->getQuery();
                    }

                    $query->orWhere("u.level = 'Terminale'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == 'Terminale'){
                          $query->andWhere("u.subject = '".$search->getSubject()."'");
                          return $query->getQuery();
                    }


                     $query->orWhere("u.level = '1re'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == '1re'){
                          $query->andWhere("u.subject = '".$search->getSubject()."'");
                          return $query->getQuery();
                    }

                    $query->orWhere("u.level = '2nde'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == '2nde'){
                          $query->andWhere("u.subject = '".$search->getSubject()."'");
                          return $query->getQuery();
                    }


                    $query->orWhere("u.level = '3eme'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == '3eme'){
                          $query->andWhere("u.subject = '".$search->getSubject()."'");
                          return $query->getQuery();
                    }

                    $query->orWhere("u.level = '4eme'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == '4eme'){
                          $query->andWhere("u.subject = '".$search->getSubject()."'");
                          return $query->getQuery();
                    }


                    $query->orWhere("u.level = '5eme'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == '5eme'){
                          $query->andWhere("u.subject = '".$search->getSubject()."'");
                          return $query->getQuery();
                    }

                    $query->orWhere("u.level = '6eme'")
                           ->andWhere("u.subject != 'rien'");

                    if($search->getLevel() == '6eme'){
                          $query->andWhere("u.subject = '".$search->getSubject()."'");
                          return $query->getQuery();
                    }

                    return $query->getQuery();


        }else{
            if($search->getSubject()){
                $query = $this->createQueryBuilder('u')
                               ->andWhere("u.subject = '".$search->getSubject()."'");
                return $query->getQuery();

            }
            $query = $this->createQueryBuilder('u')
                     ->andWhere("u.subject != 'rien'")
                     ->andWhere("u.level IS NOT NULL");
            return $query->getQuery();

        }

    }


    public function findAllUsersQuery() {
         return $this->createQueryBuilder('u')
            ->getQuery();
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
