<?php


namespace RegBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RegBundle\Entity\User;
use RegBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class PhotoController extends Controller
{

  public function PhotoAction($id)
    { 
        $tmp = $_COOKIE['id'];
        if ($tmp===null){
                return $this->redirectToRoute('index_homepage');
                        }
                        else{
                            
                            if($this->Check($id)==true){
        
           
  
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery(
                'SELECT us_img FROM RegBundle:Image us_img WHERE us_img.user_image = :id '
                                 )->setParameter('id', $id);
         $result['Image']=$query->getResult();
         $request= $this->getRequest();
         $data  = $this->get('knp_paginator')->paginate( $result['Image'], $request->query->getInt('page', 1), 3);
              
         }else {return $this->render('RegBundle:Default:UserNotFound.html.twig');}
         if($tmp==$id){  return $this->render('RegBundle:Default:myphoto.html.twig',array('data'=>$data));}
         else{ return $this->render('RegBundle:Default:photo.html.twig',array('data'=>$data));}    }
    
  }
    
        
        
        
    public function AddPhotoAction()
    {  $tmp = $_COOKIE['id'];
    $login=$_COOKIE['login'];
        $fid = "/".$tmp;
                $fs = new Filesystem();
          try {
              $fs->mkdir('..//web/img/profile'.$fid, 0755);
              } catch (IOExceptionInterface $e) {
                 echo "An error occurred while creating your directory at ".$e->getPath();
              }
              
              $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
              $qb->select('count(img.id)');
              $qb->from('RegBundle:Image','img');
              $count = $qb->getQuery()->getSingleScalarResult();
              $count+=1; 
                $target_dir = '../web/img/profile'.$fid.'/';
                $target_file = $target_dir .$count.".jpg";
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
           if(isset($_POST["submit"])) {
                if($_FILES["fileToUpload"]["tmp_name"] == null)
                    {$uploadOk = 0;}
                        else{
                            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                                if($check !== false) {
                                        $uploadOk = 1;
                                            } else {
                                                $uploadOk = 0;}}
    
           if ($uploadOk == 0) {}
             else{
                 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
                    {}
                        else {}}}
                        
               $repository = $this->getDoctrine()
                       ->getRepository('RegBundle:Image');

                        $Image = new Image();
                        $Image->setImage($target_file);
                        $Image->setUserImage($_COOKIE['id']);
                        $Image->setLikeImage('');
                        $Image->setShareImage('');
                        $Image->setProfileImage('');
                       
                        $em = $this->getDoctrine()->getEntityManager();
                        $em->persist($Image);
                        $em->flush();
              
    $referer = $this->getRequest()->headers->get('referer');
    return $this->redirect($referer);
            
}

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
public function testAction()
{ 
     $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
     $qb->select('count(img.id)');
     $qb->from('RegBundle:Image','img');
     $count = $qb->getQuery()->getSingleScalarResult();

    
  exit ("Last Inserted Id = $count");
}

}