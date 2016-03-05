<?php

namespace FriendsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    public function indexAction($id)
    {
       
          $connect=$this->get('database_connection');
      
           $friends['result']=$connect->fetchAll('SELECT friends FROM `user'.$id.'`');
            $data=[
              'friends'=>$friends['result'],
                ];
        return $this->render('FriendsBundle:Default:index.html.twig',compact('data'));
        
        
    }
}
