<?php

namespace IndexBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {        
    if (!isset($_COOKIE['id']))
    { return $this->render('RegBundle:Default:logare.html.twig');}
    else 
    {
        
    return $this->render('IndexBundle:Default:index.html.twig');}
    }
}
