<?php

namespace RegBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RegBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{ 
   
    public function indexAction()
    {  
        $tmp = $this->get('session')->get('login');
    if (empty($tmp))
    { return $this->render('RegBundle:Default:register.html.twig');}
    else 
        {return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));}
    }
   
    public function regAction()
{
        if (isset($_POST['username'])) { $login = $_POST['username']; if ($login == '') { unset($login);} } 
        if (isset($_POST['email'])) { $email = $_POST['email']; if ($email == '') { unset($email);} } 
        if (isset($_POST['pass'])) { $password=$_POST['pass']; if ($password =='') { unset($password);} }
        if (empty($login) or empty($password) or (empty($email))) 
            {
              exit ("Nu ati completat toate cimpurile");
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
    $user->setInfo($_POST['info']);
    $user->setNume($nume);
    $user->setPrenume($prenume);
    $user->setEmail($email);

    $em = $this->getDoctrine()->getEntityManager();
    $em->persist($user);
    $em->flush();

    return new Response('Created user id '.$user->getId());} 
    
     else
         {exit ('Loginul este ocupat! ');}
      } 
 else {
        exit ('Email-ul este ocupat! ');  
      }
   
  
        
}

public function loagareAction()
    {$tmp = $this->get('session')->get('login');
    if (empty($tmp))
    { return $this->render('RegBundle:Default:logare.html.twig');}
    else 
        {return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));}
    }
    
 public function logAction()
 {
       //session_start();
if (isset($_POST['username'])) { $login = $_POST['username']; if ($login == '') { unset($login);} } 
    if (isset($_POST['pass'])) { $password=$_POST['pass']; if ($password =='') { unset($password);} }
    
if (empty($login) or empty($password)) 
    {
    exit ("Nu ati completat toate cimpurile");
    }
   
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
         
          if ($result==null){
               exit ("Login-ul sau parola introdusa de dumnevoastra este gresita!!");
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
          
         if($result==null){
             exit("Login-ul sau parola introdusa de dumnevoastra este gresita!!");} 
                       else
                          {
                           $request = $this->getRequest();
                            $session = $request->getSession();

                          $session->set('login', $result->getUsername() );
                         $session->set('id', $result->getId());
                                return $this->redirect('/my_project_name/web/app_dev.php/');
                          }
          
         
                 }
   }
   public function exitAction()
     { $this->get('session')->remove('login');
       $this->get('session')->remove('id');
       return $this->redirect('/my_project_name/web/app_dev.php/');}


public function MyProfileAction()
{   $tmp = $this->get('session')->get('login');
    if (empty($tmp)){
        return $this->redirect('/my_project_name/web/app_dev.php/');
    }
    else{ $login=$tmp;
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
  $data=['id'=>$result->getId(),
         'username'=> $result->getUsername(),
         'email'=> $result->getEmail(),
         'nume'=>$result->getNume(),
         'prenume'=>$result->getPrenume(),
         'info'=>$result->getInfo(),
      
      ];
   
    return $this->render('RegBundle:Default:MyProfile.html.twig',array('data'=>$data));
}


     }

}