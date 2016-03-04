<?php

namespace helloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class DefaultController extends Controller
{
    public function indexAction(){
   
        return $this->render('helloBundle:Default:index.html.twig');
    }
     public function introAction()
    { //  $myData= date_create($_POST['an']-$_POST['luna']-$_POST['zi']);
         $an=$_POST['an'];
         $luna=$_POST['luna'];
         $zi=$_POST['zi'];
    $myData= date_create("$an-$luna-$zi");
         exit (date_format($myData,'Y - m - d') )  ;
        return $this->render('helloBundle:Default:intro.html.twig');
    }
}

