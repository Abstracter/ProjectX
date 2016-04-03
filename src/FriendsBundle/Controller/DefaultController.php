<?php

namespace FriendsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    public function indexAction($id)
    {
       
          $connect=$this->get('database_connection');
          $tableExists = $connect->query("SHOW TABLES LIKE 'user".$id."'")->rowCount() > 0;
        if ($tableExists==1)
           {
            $friends['result']=$connect->fetchAll('SELECT friends FROM `user'.$id.'` WHERE friends>=1');
            $scoate=array();
            $c=0;
             foreach ($friends['result'] as $as)
                 foreach ($as as $b)
                     if (($b!=="")||($b!==null)){$c++;$scoate[]=$b;}
                      if ($c>0){
                      $data=['friends'=>$connect->fetchAll('SELECT id,nume,prenume,img FROM user WHERE id IN('.implode(',',$scoate).')'),
                            ];
                      }else {$data=['nofriends'=>"nu sunt prieteni",];}
         }else
           {$data=['nofriends'=>'nu sa gasit prieteni',];}
        return $this->render('FriendsBundle:Default:index.html.twig',compact('data'));
    }
   public function adaugaprietenAction($id)
    {
         $repository = $this->getDoctrine()
                              ->getRepository('RegBundle:User');
        $e = $this->getDoctrine()->getEntityManager();
        $query = $e->createQuery(
          'SELECT user FROM RegBundle:user user WHERE user.id = :id') 
              ->setParameter('id', $id)         
              ->setMaxResults(1);
     try {
                  $result = $query->getSingleResult();
         } 
     catch (\Doctrine\Orm\NoResultException $e) {
                  $result = null;
          }
          if($result==null){return $this->render('RegBundle:Default:UserNotFound.html.twig');}
          else{
           $connect=$this->get('database_connection');
           $connect->executeUpdate('INSERT INTO `user'.$id.'`(cereri) VALUES ('.$_COOKIE['id'].')');
           $cerere=$connect->fetchAll('SELECT cereri FROM `user'.$id.'` where cereri= '.$_COOKIE['id']);
      if ($id===$_COOKIE['id']){
            $cerere['result']=$connect->fetchAll('SELECT DISTINCT cereri FROM `user'.$_COOKIE['id'].'`WHERE cereri>=1');
            $cer=['cererip'=>$cerere['result'],];
        }else{
             $cerere['result']=$connect->fetchAll('SELECT DISTINCT cereri FROM `user'.$id.'` where cereri='.$_COOKIE['id']);
                $cer=['cereri'=>$cerere['result'],];  
                  }
          return $this->render('RegBundle:Default:MyProfile.html.twig',array('cer'=>$cer));
          
        }                        
    }
    public function acceptAction($id){
        $connect=$this->get('database_connection');
        $connect->executeUpdate('UPDATE `user'.$_COOKIE['id'].'` SET cereri=NULL WHERE cereri='.$id);
        $connect->executeUpdate('INSERT INTO `user'.$_COOKIE['id'].'`(friends) VALUES ('.$id.')');
        $connect->executeUpdate('INSERT INTO `user'.$id.'`(friends) VALUES ('.$_COOKIE['id'].')');
        
    }
    public function creazaAction()
    {
            $connect=$this->get('database_connection');
            $ida['result']=$connect->fetchAll('SELECT id FROM user');
            $id="";
            $count=0;
            foreach ($ida['result']as $a)
            {
            $id=$a['id']; 
            $connect->query("DROP TABLE IF EXISTS user".$id."");
            $sql="CREATE TABLE IF NOT EXISTS user".$id." (
            id INT(11) NOT NULL AUTO_INCREMENT,
            img VARCHAR(255) DEFAULT NULL,
            coment TEXT DEFAULT NULL,
            cereri INT(11) DEFAULT NULL,
            friends INT(11) DEFAULT NULL,
            action VARCHAR(255) DEFAULT NULL,
            likee TEXT DEFAULT NULL,
            PRIMARY KEY (id)
            )";
            $connect->query($sql);
            $count++;
            }
         $data=['utilizatori'=>$count,];
        return $this->render('FriendsBundle:Default:uti.html.twig',compact('data'));
    }
}
