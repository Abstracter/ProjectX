<?php

namespace RegBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RegBundle\Entity\User;
use RegBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class DefaultController extends Controller
{ 
   
    public function indexAction()
    {  $request = $this->get('request');
      $tmp =  $request->get('id');
              $tmp = $this->get('request')->request->get('id');
    if (empty($tmp))
          { return $this->render('RegBundle:Default:register.html.twig');}
    else 
          { return $this->redirectToRoute('index_homepage');}
    }
   
    public function regAction()
{    
      

        if (isset($_POST['username'])) { $login = $_POST['username']; if ($login == '') { unset($login);} } 
        if (isset($_POST['email'])) { $email = $_POST['email']; if ($email == '') { unset($email);} } 
        if (isset($_POST['pass'])) { $password=$_POST['pass']; if ($password =='') { unset($password);} }
        if (empty($login) or empty($password) or (empty($email))) 
            {
              return $this->updateAction('golreg');
            }
    
            $login = stripslashes($login);
            $login = htmlspecialchars($login);
            $password = stripslashes($password);
            $password = htmlspecialchars($password);
            $login = trim($login);
            $password = trim($password);
     
            $nume = stripslashes($_POST['nume']);
            $nume = htmlspecialchars($_POST['nume']);
            $prenume = stripslashes($_POST['prenume']);
            $prenume = htmlspecialchars($_POST['prenume']);
            $nume = trim($_POST['nume']);
            $prenume = trim($_POST['prenume']);
    
               $an=$_POST['an'];
               $luna=$_POST['luna'];
              $zi=$_POST['zi'];
          $Date= date_create("$an-$luna-$zi");
        
         
            $repository = $this->getDoctrine()
                 ->getRepository('RegBundle:User');
           
 
            $e = $this->getDoctrine()->getEntityManager();
            $query = $e->createQuery(
                     'SELECT user FROM RegBundle:user user WHERE user.Email = :Email ') 
                        ->setParameter('Email', $email)
                        ->setMaxResults(1);


          try {
            $result = $query->getSingleResult();
              } catch (\Doctrine\Orm\NoResultException $e) {
            $result = null;
          
              }
         if ($result==null){
             $e = $this->getDoctrine()->getEntityManager();
             $query = $e->createQuery(
                'SELECT user FROM RegBundle:user user WHERE  user.Username = :Username ') 
                      ->setParameter('Username', $login)
                      ->setMaxResults(1);


          try {
               $result = $query->getSingleResult();
               } catch (\Doctrine\Orm\NoResultException $e) {
               $result = null;
               }
         
          if ($result==null){
            $user = new User();
            $user->setUsername($login);
            $user->setPass($password);
            $user->setInfo('');
            $user->setNume($nume);
            $user->setPrenume($prenume);
            $user->setEmail($email);
            $user->setImg('../web/img/default.png');
            $user->setAn($Date);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();
            
            $connect=$this->get('database_connection');
            $ida['result']=$connect->fetchAll('SELECT id FROM `user` ORDER BY `user`.`id` DESC LIMIT 1');
            $id="";
            foreach ($ida['result']as $a)
            {
               $id=$a['id']; 
            }
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
    
    
        return $this->updateAction('created');} 
    
     else
         {return $this->updateAction('login');}
      } 
     else 
         {return $this->updateAction('email');}
   
  }


    
 public function logAction()
 {
       //session_start();
    
        if (isset($_POST['username'])) { $login = $_POST['username']; if ($login == '') { unset($login);} } 
        if (isset($_POST['pass'])) { $password=$_POST['pass']; if ($password =='') { unset($password);} }
        if (empty($login) or empty($password)) 
                {
                    return $this->updateAction('gol');}
    
    
   
            $login = stripslashes($login);
            $login = htmlspecialchars($login);
            $password = stripslashes($password);
            $password = htmlspecialchars($password);
            $login = trim($login);
            $password = trim($password);
    
            $repository = $this->getDoctrine()
                 ->getRepository('RegBundle:User');

            $e = $this->getDoctrine()->getEntityManager();
            $query = $e->createQuery(
                 'SELECT user FROM RegBundle:user user WHERE user.Username = :Username ORDER BY user.Username') 
                        ->setParameter('Username', $login)
                        ->setMaxResults(1);


     try {
                  $result = $query->getSingleResult();
         }
     catch (\Doctrine\Orm\NoResultException $e) {
                  $result = null;
         }
    
    
    {
          if ($result==null){
              return $this->updateAction('gresit');
               
          }
          else
              {
              $e = $this->getDoctrine()->getEntityManager();
              $query = $e->createQuery(
                    "SELECT user FROM RegBundle:user user WHERE user.Pass =:Pass AND user.Username =:Username")
                            ->setParameter('Username', $login)
                            ->setParameter('Pass', $password)
                            ->setMaxResults(1);

     try {
                  $result = $query->getSingleResult();
         } 
     catch (\Doctrine\Orm\NoResultException $e) {
                  $result = null;
          }
          
         if($result===null){
         return $this->updateAction('gresit');}
              
                       else
                          {
                           
                        setcookie ("id",  $result->getId() , time() + 24*3600);
                        setcookie ("login", $result->getUsername() , time() + 24*3600);
                           
                        
                           
        {return $this->redirectToRoute('index_homepage');}
              }}
                
  
         
 }
    }
   
public function exitAction()
     { 
     setcookie ("id", "", time() - 3600);
     setcookie ("login", "", time() - 24*3600);
       
        return $this->redirectToRoute('index_homepage');}


public function MyProfileAction($id)
{   
    if (!isset($_COOKIE['id'])){
                return $this->redirectToRoute('index_homepage');
                        }
                        else{
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
           if ($id===$_COOKIE['id']){
   $cerere=$connect->fetchAll('SELECT DISTINCT cereri FROM `user'.$_COOKIE['id'].'`WHERE cereri>=1');
   $scoate=array();
        $c=0;
        foreach ($cerere as $as)
           foreach ($as as $b)
               if (($b!=="")||($b!==null)){$c++;$scoate[]=$b;}
                     if ($c>0){
        $cer=['cererip'=>$connect->fetchAll('SELECT nume,prenume FROM user WHERE id IN('.implode(',',$scoate).')'),];
                     }else {$cer=['cererip'=>"",];}
         }else{
   $cerere['result']=$connect->fetchAll('SELECT DISTINCT cereri FROM `user'.$id.'` where cereri='.$_COOKIE['id']);
        $cer=['cereri'=>$cerere['result'],];  
        }
            $data=['id'=>$result->getId(),
                   'username'=> $result->getUsername(),
                   'email'=> $result->getEmail(),
                   'nume'=>$result->getNume(),
                   'prenume'=>$result->getPrenume(),
                   'info'=>$result->getInfo(),
                   'image'=>$result->getImg(),
                   'An'=>$result->getAn(),
                ];
          return $this->render('RegBundle:Default:MyProfile.html.twig',array('data'=>$data,'cer'=>$cer));}

                        }
   }

 public function updateAction($var)
{
      if($var=='gol')
        {
        $this->get('session')->getFlashBag()->set('notice', 'Empty username or password.');
                return $this->redirect($this->generateUrl('index_homepage'));}
                
      elseif ($var=='ggolreg') {
          $this->get('session')->getFlashBag()->set('notice', 'Empty username or password.');
                return $this->redirect($this->generateUrl('reg_homepage')); }
      elseif ($var=='gresit') {
          $this->get('session')->getFlashBag()->set('notice', 'Incorrect username or password.');
                return $this->redirect($this->generateUrl('index_homepage')); }
      elseif ($var=='email') {
          $this->get('session')->getFlashBag()->set('notice', 'Email is invalid or already taken.');
                return $this->redirect($this->generateUrl('reg_homepage')); } 
      elseif ($var=='login') {
          $this->get('session')->getFlashBag()->set('notice', 'Username is already taken.');
                return $this->redirect($this->generateUrl('reg_homepage')); }  
      elseif ($var=='created') {
          $this->get('session')->getFlashBag()->set('notice', 'Registration was succesifull!');
                return $this->redirect($this->generateUrl('reg_homepage')); }  
    } 
    
  

public function TestAction($id)
{ exit ("Test proiden,id geted $id" );}
 
 
 public function Check($id)
 {$repository = $this->getDoctrine()
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
          if($result==null){$response=false;}else{$response=true;}
          return $response;
 }





}
