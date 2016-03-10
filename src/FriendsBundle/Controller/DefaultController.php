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
