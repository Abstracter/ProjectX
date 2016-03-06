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
            $friends['result']=$connect->fetchAll('SELECT friends FROM `user'.$id.'`');
            $data=['friends'=>$friends['result'],];
           }
        else
           {
               $data=['nofriends'=>'nu sa gasit prieteni',];
           }
        return $this->render('FriendsBundle:Default:index.html.twig',compact('data'));
        
        
    }
}
