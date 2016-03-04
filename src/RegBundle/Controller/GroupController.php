<?php

namespace RegBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RegBundle\Entity\User;
use RegBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;



class GroupController extends Controller
{ 
    
    public function groupAction($id)
{    $data=['id'=>$id];
        return $this->render('RegBundle:Default:group.html.twig',array('data'=>$data));
}


}