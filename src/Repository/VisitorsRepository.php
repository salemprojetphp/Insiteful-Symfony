<?php

namespace App\Repository;

use App\Entity\Visitors;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visitors>
 */
class VisitorsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visitors::class);
    }

   public function findUserWebsites($user_id): array
   {
       return $this->createQueryBuilder('v')
                    ->select("distinct v.website")
                    ->where('v.user_id = :val')
                    ->setParameter('val', $user_id)
                    ->getQuery()
                    ->getResult()
       ;
   }
   public function baseQuery($user, $website){
        return $this->createQueryBuilder('v')
                    ->select("count(v.website)")
                    ->where("v.user_id = :val1")
                    ->andWhere("v.website = :val2")
                    ->setParameter("val1", $user)
                    ->setParameter("val2", $website);
   }
   public function findNumberOfVisits($user, $website){
        return $this->baseQuery($user, $website)
                    ->getQuery()
                    ->getSingleScalarResult();
   }
   public function findNumberOfDirectVisits($user, $website){
        return $this->baseQuery($user, $website)
                    ->andWhere("v.referrer= 'Direct'")
                    ->getQuery()
                    ->getSingleScalarResult();
   }
   public function findNumberOfSocialMediaVisits($user, $website){
        return $this->baseQuery($user, $website)
                    ->andWhere("v.referrer !='Direct'")
                    ->getQuery()
                    ->getSingleScalarResult();
   }
   public function findNumberOfSearchEngines($user, $website){
        return $this->baseQuery($user, $website)
                    ->andWhere("v.browser !='Other' ")
                    ->getQuery()
                    ->getSingleScalarResult();
   }
   public function generateJSONFile($queryRes, $JSONFileName, $colonne){
        $data = array();
        if($queryRes != ''){
            foreach($queryRes as $result) : 
                $data[$result->$colonne] = $result->number;
            endforeach;
        }
        $encoded_data = json_encode($data, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);
        file_put_contents("public/json/".$JSONFileName.".json", $encoded_data);
    }
    public function baseChartQuery($user_id, $website, $colonne){
        return $this->createQueryBuilder("v")
                    ->select("v.:val1, count(v.website)")
                    ->where("v.user_id = :val2")
                    ->andWhere("v.website = :val3")
                    ->groupBy("v.:val4")
                    ->setParameter("val1", $colonne)
                    ->setParameter("val2", $user_id)
                    ->setParameter("val2", $website)
                    ->setParameter("val4", $colonne)
                    ->getQuery()
                    ->getResult();
    }
//    public function findOneBySomeField($value): ?Visitors
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
